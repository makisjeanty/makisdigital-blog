# Backup Runbook

## Scope

- Database dump (`mysql`) in compressed `.sql.gz`
- Application files in compressed `.tar.gz`
- SHA-256 manifest for integrity check

## Command

```bash
chmod +x scripts/backup.sh
./scripts/backup.sh
```

Optional checks:

```bash
./scripts/backup.sh --dry-run
./scripts/backup.sh --skip-db
./scripts/backup.sh --skip-files
```

## Output

Backups are written to `storage/backups` by default:

- `makisdigital-blog-YYYYMMDD-HHMMSS.sql.gz`
- `makisdigital-blog-YYYYMMDD-HHMMSS.files.tar.gz`
- `makisdigital-blog-YYYYMMDD-HHMMSS.manifest.txt`

Override directory:

```bash
BACKUP_DIR=/path/secure-backups ./scripts/backup.sh
```

## Restore (Database)

```bash
gunzip -c storage/backups/<backup>.sql.gz | mysql -h <host> -P <port> -u <user> -p <database>
```

## Restore (Files)

```bash
tar -xzf storage/backups/<backup>.files.tar.gz -C /path/to/restore/dir
```

## Verification

Use manifest checksums:

```bash
sha256sum -c storage/backups/<backup>.manifest.txt
```
