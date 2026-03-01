#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BACKUP_DIR="${BACKUP_DIR:-$ROOT_DIR/storage/backups}"
TIMESTAMP="$(date +%Y%m%d-%H%M%S)"
APP_NAME="${APP_NAME:-makisdigital-blog}"
DRY_RUN=0
INCLUDE_DB=1
INCLUDE_FILES=1

usage() {
  cat <<'EOF'
Usage: scripts/backup.sh [--dry-run] [--skip-db] [--skip-files]

Environment overrides:
  BACKUP_DIR   Output directory (default: storage/backups)
  APP_NAME     Prefix in backup filenames (default: makisdigital-blog)
EOF
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    --dry-run)
      DRY_RUN=1
      shift
      ;;
    --skip-db)
      INCLUDE_DB=0
      shift
      ;;
    --skip-files)
      INCLUDE_FILES=0
      shift
      ;;
    -h|--help)
      usage
      exit 0
      ;;
    *)
      echo "Unknown option: $1"
      usage
      exit 1
      ;;
  esac
done

run_cmd() {
  if [[ "$DRY_RUN" -eq 1 ]]; then
    echo "[dry-run] $*"
    return 0
  fi
  "$@"
}

mkdir -p "$BACKUP_DIR"

get_env_value() {
  local key="$1"
  local env_file="$ROOT_DIR/.env"
  if [[ ! -f "$env_file" ]]; then
    return 0
  fi

  local raw
  raw="$(grep -E "^${key}=" "$env_file" | tail -n 1 | cut -d= -f2- || true)"
  raw="${raw%\"}"
  raw="${raw#\"}"
  raw="${raw%\'}"
  raw="${raw#\'}"
  printf '%s' "$raw"
}

DB_CONNECTION="${DB_CONNECTION:-$(get_env_value DB_CONNECTION)}"
DB_HOST="${DB_HOST:-$(get_env_value DB_HOST)}"
DB_PORT="${DB_PORT:-$(get_env_value DB_PORT)}"
DB_DATABASE="${DB_DATABASE:-$(get_env_value DB_DATABASE)}"
DB_USERNAME="${DB_USERNAME:-$(get_env_value DB_USERNAME)}"
DB_PASSWORD="${DB_PASSWORD:-$(get_env_value DB_PASSWORD)}"

DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3306}"

MANIFEST_FILE="$BACKUP_DIR/${APP_NAME}-${TIMESTAMP}.manifest.txt"
run_cmd bash -lc "cat > '$MANIFEST_FILE' <<'EOF'
backup_timestamp=$TIMESTAMP
app_name=$APP_NAME
host=$(hostname)
cwd=$ROOT_DIR
include_db=$INCLUDE_DB
include_files=$INCLUDE_FILES
EOF"

if [[ "$INCLUDE_DB" -eq 1 ]]; then
  if [[ "$DB_CONNECTION" != "mysql" ]]; then
    echo "Skipping DB backup: DB_CONNECTION is '$DB_CONNECTION' (expected mysql)."
  elif ! command -v mysqldump >/dev/null 2>&1; then
    echo "Skipping DB backup: mysqldump not found."
  elif [[ -z "$DB_DATABASE" || -z "$DB_USERNAME" ]]; then
    echo "Skipping DB backup: DB_DATABASE/DB_USERNAME missing."
  else
    DB_OUT="$BACKUP_DIR/${APP_NAME}-${TIMESTAMP}.sql.gz"
    if [[ "$DRY_RUN" -eq 1 ]]; then
      echo "[dry-run] MYSQL_PWD=*** mysqldump -h $DB_HOST -P $DB_PORT -u $DB_USERNAME $DB_DATABASE | gzip > $DB_OUT"
    else
      MYSQL_PWD="$DB_PASSWORD" mysqldump \
        --single-transaction \
        --quick \
        --routines \
        --triggers \
        -h "$DB_HOST" \
        -P "$DB_PORT" \
        -u "$DB_USERNAME" \
        "$DB_DATABASE" | gzip > "$DB_OUT"
      sha256sum "$DB_OUT" >> "$MANIFEST_FILE"
      echo "Database backup created: $DB_OUT"
    fi
  fi
fi

if [[ "$INCLUDE_FILES" -eq 1 ]]; then
  FILES_OUT="$BACKUP_DIR/${APP_NAME}-${TIMESTAMP}.files.tar.gz"
  TAR_EXCLUDES=(
    "--exclude=.git"
    "--exclude=node_modules"
    "--exclude=vendor"
    "--exclude=storage/logs"
    "--exclude=storage/framework/cache"
    "--exclude=storage/framework/sessions"
    "--exclude=storage/framework/views"
    "--exclude=storage/backups"
    "--exclude=.env"
    "--exclude=.cpanel.deploy.env"
    "--exclude=.cpanel.deploy.env.env"
  )

  if [[ "$DRY_RUN" -eq 1 ]]; then
    echo "[dry-run] tar -czf $FILES_OUT ${TAR_EXCLUDES[*]} (project selected files)"
  else
    tar -czf "$FILES_OUT" "${TAR_EXCLUDES[@]}" \
      -C "$ROOT_DIR" \
      app bootstrap config database public resources routes composer.json composer.lock artisan README.md phpunit.xml package.json package-lock.json vite.config.js postcss.config.js tailwind.config.js
    sha256sum "$FILES_OUT" >> "$MANIFEST_FILE"
    echo "Files backup created: $FILES_OUT"
  fi
fi

if [[ "$DRY_RUN" -eq 0 ]]; then
  echo "Manifest: $MANIFEST_FILE"
  echo "Backup finished successfully."
else
  echo "Dry-run completed."
fi
