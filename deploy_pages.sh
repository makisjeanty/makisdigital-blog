#!/bin/bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
DEPLOY_ENV_FILE="${DEPLOY_ENV_FILE:-$ROOT_DIR/.cpanel.deploy.env}"

# Load optional deploy env file for terminal sessions that don't keep exports.
if [ -f "$DEPLOY_ENV_FILE" ]; then
    # shellcheck disable=SC1090
    source "$DEPLOY_ENV_FILE"
fi

API_TOKEN="${CPANEL_API_TOKEN:-}"
USER="${CPANEL_USER:-}"
IP="${CPANEL_HOST:-}"  # Ex: sh00132.hostgator.com.br

# Trim accidental newlines/spaces from copied tokens.
API_TOKEN="$(printf '%s' "$API_TOKEN" | tr -d '\r\n')"

if [ -z "$USER" ] || [ -z "$IP" ]; then
    echo "Missing deploy credentials. Set CPANEL_USER and CPANEL_HOST (or use $DEPLOY_ENV_FILE)."
    exit 1
fi

if [ -z "$API_TOKEN" ]; then
    if [ -t 0 ]; then
        read -rsp "CPANEL_API_TOKEN: " API_TOKEN
        echo
        API_TOKEN="$(printf '%s' "$API_TOKEN" | tr -d '\r\n')"
    fi
fi

if [ -z "$API_TOKEN" ]; then
    echo "Missing deploy credentials. Set CPANEL_API_TOKEN (or use $DEPLOY_ENV_FILE)."
    exit 1
fi

CURL_INSECURE="${CPANEL_INSECURE:-0}"
if [ "$CURL_INSECURE" = "1" ]; then
    CURL_TLS_FLAG="-k"
else
    CURL_TLS_FLAG=""
fi

# Prefer hostnames for valid TLS certificates.
# If CPANEL_HOST is an IP, try reverse DNS to find a usable hostname.
API_HOST="$IP"
if [[ "$IP" =~ ^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$ ]] && [ "$CURL_INSECURE" != "1" ]; then
    PTR_HOST="$(getent hosts "$IP" | awk '{print $2}' | head -n 1)"
    if [ -z "$PTR_HOST" ]; then
        PTR_HOST="$(host "$IP" 2>/dev/null | awk '/pointer/ {print $5}' | sed 's/\.$//' | head -n 1)"
    fi

    if [ -n "$PTR_HOST" ]; then
        API_HOST="$PTR_HOST"
        echo "Using reverse DNS host for TLS: $API_HOST"
    fi
fi

upload_file() {
    local local_path=$1
    local remote_dir=$2
    local remote_file=$3

    if [ ! -f "$local_path" ]; then
        echo "Skipping $local_path: File not found locally."
        return
    fi

    echo "Uploading $local_path to $remote_dir/$remote_file..."
    response="$(curl $CURL_TLS_FLAG -sS -X POST -H "Authorization: cpanel $USER:$API_TOKEN" \
         --data-urlencode "dir=$remote_dir" \
         --data-urlencode "file=$remote_file" \
         --data-urlencode "content@$local_path" \
         "https://$API_HOST:2083/execute/Fileman/save_file_content")"
    echo "$response"

    if echo "$response" | grep -qi "Access denied"; then
        echo "ERROR: Access denied while uploading $remote_file. Check token permissions."
        exit 1
    fi

    if echo "$response" | grep -q '"status":0'; then
        echo "ERROR: Upload failed for $remote_file."
        exit 1
    fi

    echo
}

# Tenta criar diretório via API 2
create_dir() {
    local parent=$1
    local name=$2
    if [ -z "$name" ]; then
        return
    fi

    echo "Creating directory $name in $parent..."
    response="$(curl $CURL_TLS_FLAG -sS -H "Authorization: cpanel $USER:$API_TOKEN" \
         "https://$API_HOST:2083/json-api/cpanel?cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Fileman&cpanel_jsonapi_func=mkdir&path=$parent&name=$name")"
    echo "$response"

    if echo "$response" | grep -qi "Access denied"; then
        echo "ERROR: Access denied while creating directory $name. Check token permissions."
        exit 1
    fi
}

# Estrutura de Diretórios
create_dir "public_html/app" "Services"
create_dir "public_html/app" "Agents"
create_dir "public_html/app/Agents" "Contracts"
create_dir "public_html/app" "Policies"
create_dir "public_html/app/Http" "Requests"
create_dir "public_html/app" "Providers"
create_dir "public_html/app" "Models"
create_dir "public_html/app/Http" "Middleware"
create_dir "public_html/resources/views/admin" "posts"
create_dir "public_html/resources/views/admin" "messages"
create_dir "public_html/resources/views/admin" "courses"
create_dir "public_html/resources/views/admin" "newsletters"
create_dir "public_html/resources/views/admin" "media"
create_dir "public_html/resources/views/admin" "users"
create_dir "public_html/resources/views/admin" "settings"
create_dir "public_html/resources/views/admin" "lessons"
create_dir "public_html/resources/views/admin" "categories"
create_dir "public_html/resources/views/admin" "tags"
create_dir "public_html/resources/views/admin" "agents"
create_dir "public_html/app/Http/Controllers" "Admin"
create_dir "public_html/app/Http/Controllers" "Api"
create_dir "public_html/resources/views" "courses"
create_dir "public_html/resources/views" "blog"
create_dir "public_html/resources/views" "components"
create_dir "public_html/resources/views/components" "blog"
create_dir "public_html/resources/views/components" "course"
create_dir "public_html/resources/views/components" "admin"
create_dir "public_html/resources/views/components" "form"
create_dir "public_html/resources/views" "auth"
create_dir "public_html/resources/views" "profile"
create_dir "public_html/resources/views" "student"
create_dir "public_html/resources/views/profile" "partials"
create_dir "public_html/public" "css"
create_dir "public_html/public" "js"

# Static Assets (Images, etc)
create_dir "public_html/app/Http/Controllers" "Auth"
create_dir "public_html/public" "build"
create_dir "public_html/public/build" "assets"
create_dir "public_html/database" "migrations"
create_dir "public_html/database" "seeders"

# Core & Config
upload_file "$ROOT_DIR/routes/web.php" "public_html/routes" "web.php"
upload_file "$ROOT_DIR/routes/api.php" "public_html/routes" "api.php"
upload_file "$ROOT_DIR/bootstrap/app.php" "public_html/bootstrap" "app.php"
upload_file "$ROOT_DIR/config/app.php" "public_html/config" "app.php"
if [ "${UPLOAD_DOTENV:-0}" = "1" ]; then
    upload_file "$ROOT_DIR/.env" "public_html" ".env"
fi
upload_file "$ROOT_DIR/.htaccess" "public_html" ".htaccess"
upload_file "$ROOT_DIR/composer.json" "public_html" "composer.json"
upload_file "$ROOT_DIR/composer.lock" "public_html" "composer.lock"
upload_file "$ROOT_DIR/bootstrap/app.php" "public_html/bootstrap" "app.php"

# Services & Policies
upload_file "$ROOT_DIR/app/Services/PostService.php" "public_html/app/Services" "PostService.php"
upload_file "$ROOT_DIR/app/Services/CourseService.php" "public_html/app/Services" "CourseService.php"
upload_file "$ROOT_DIR/app/Services/AgentRunnerService.php" "public_html/app/Services" "AgentRunnerService.php"
upload_file "$ROOT_DIR/app/Agents/ContentAgent.php" "public_html/app/Agents" "ContentAgent.php"
upload_file "$ROOT_DIR/app/Agents/CourseAgent.php" "public_html/app/Agents" "CourseAgent.php"
upload_file "$ROOT_DIR/app/Agents/MonetizationAgent.php" "public_html/app/Agents" "MonetizationAgent.php"
upload_file "$ROOT_DIR/app/Agents/AnalyticsAgent.php" "public_html/app/Agents" "AnalyticsAgent.php"
upload_file "$ROOT_DIR/app/Agents/GrowthAgent.php" "public_html/app/Agents" "GrowthAgent.php"
upload_file "$ROOT_DIR/app/Agents/AgentRegistry.php" "public_html/app/Agents" "AgentRegistry.php"
upload_file "$ROOT_DIR/app/Agents/Contracts/AgentInterface.php" "public_html/app/Agents/Contracts" "AgentInterface.php"
upload_file "$ROOT_DIR/app/Policies/PostPolicy.php" "public_html/app/Policies" "PostPolicy.php"
upload_file "$ROOT_DIR/app/Http/Middleware/RoleMiddleware.php" "public_html/app/Http/Middleware" "RoleMiddleware.php"
upload_file "$ROOT_DIR/app/Http/Middleware/EnsureAgentAccess.php" "public_html/app/Http/Middleware" "EnsureAgentAccess.php"

# Requests
upload_file "$ROOT_DIR/app/Http/Requests/StorePostRequest.php" "public_html/app/Http/Requests" "StorePostRequest.php"
upload_file "$ROOT_DIR/app/Http/Requests/UpdatePostRequest.php" "public_html/app/Http/Requests" "UpdatePostRequest.php"
upload_file "$ROOT_DIR/app/Http/Requests/StoreCourseRequest.php" "public_html/app/Http/Requests" "StoreCourseRequest.php"
upload_file "$ROOT_DIR/app/Http/Requests/UpdateCourseRequest.php" "public_html/app/Http/Requests" "UpdateCourseRequest.php"
upload_file "$ROOT_DIR/app/Http/Requests/StoreMessageRequest.php" "public_html/app/Http/Requests" "StoreMessageRequest.php"

# Controllers
upload_file "$ROOT_DIR/app/Http/Controllers/Controller.php" "public_html/app/Http/Controllers" "Controller.php"
upload_file "$ROOT_DIR/app/Http/Controllers/HomeController.php" "public_html/app/Http/Controllers" "HomeController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/PostController.php" "public_html/app/Http/Controllers" "PostController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/CourseController.php" "public_html/app/Http/Controllers" "CourseController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/ContactController.php" "public_html/app/Http/Controllers" "ContactController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/SitemapController.php" "public_html/app/Http/Controllers" "SitemapController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/NewsletterController.php" "public_html/app/Http/Controllers" "NewsletterController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/MercadoPagoController.php" "public_html/app/Http/Controllers" "MercadoPagoController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/DashboardController.php" "public_html/app/Http/Controllers" "DashboardController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Api/AgentRunController.php" "public_html/app/Http/Controllers/Api" "AgentRunController.php"
upload_file "$ROOT_DIR/config/services.php" "public_html/config" "services.php"

# Auth Controllers
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/AuthenticatedSessionController.php" "public_html/app/Http/Controllers/Auth" "AuthenticatedSessionController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/ConfirmablePasswordController.php" "public_html/app/Http/Controllers/Auth" "ConfirmablePasswordController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/EmailVerificationNotificationController.php" "public_html/app/Http/Controllers/Auth" "EmailVerificationNotificationController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/EmailVerificationPromptController.php" "public_html/app/Http/Controllers/Auth" "EmailVerificationPromptController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/NewPasswordController.php" "public_html/app/Http/Controllers/Auth" "NewPasswordController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/PasswordController.php" "public_html/app/Http/Controllers/Auth" "PasswordController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/PasswordResetLinkController.php" "public_html/app/Http/Controllers/Auth" "PasswordResetLinkController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/RegisteredUserController.php" "public_html/app/Http/Controllers/Auth" "RegisteredUserController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Auth/VerifyEmailController.php" "public_html/app/Http/Controllers/Auth" "VerifyEmailController.php"

# Providers
upload_file "$ROOT_DIR/app/Providers/AppServiceProvider.php" "public_html/app/Providers" "AppServiceProvider.php"

# Admin Controllers
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/DashboardController.php" "public_html/app/Http/Controllers/Admin" "DashboardController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/NewsletterController.php" "public_html/app/Http/Controllers/Admin" "NewsletterController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/MediaController.php" "public_html/app/Http/Controllers/Admin" "MediaController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/UserController.php" "public_html/app/Http/Controllers/Admin" "UserController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/SettingsController.php" "public_html/app/Http/Controllers/Admin" "SettingsController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/CourseController.php" "public_html/app/Http/Controllers/Admin" "CourseController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/LessonController.php" "public_html/app/Http/Controllers/Admin" "LessonController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/CategoryController.php" "public_html/app/Http/Controllers/Admin" "CategoryController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/TagController.php" "public_html/app/Http/Controllers/Admin" "TagController.php"
upload_file "$ROOT_DIR/app/Http/Controllers/Admin/AgentController.php" "public_html/app/Http/Controllers/Admin" "AgentController.php"

# Models
upload_file "$ROOT_DIR/app/Models/User.php" "public_html/app/Models" "User.php"
upload_file "$ROOT_DIR/app/Models/Post.php" "public_html/app/Models" "Post.php"
upload_file "$ROOT_DIR/app/Models/Course.php" "public_html/app/Models" "Course.php"
upload_file "$ROOT_DIR/app/Models/CourseModule.php" "public_html/app/Models" "CourseModule.php"
upload_file "$ROOT_DIR/app/Models/CourseLesson.php" "public_html/app/Models" "CourseLesson.php"
upload_file "$ROOT_DIR/app/Models/Category.php" "public_html/app/Models" "Category.php"
upload_file "$ROOT_DIR/app/Models/Tag.php" "public_html/app/Models" "Tag.php"
upload_file "$ROOT_DIR/app/Models/Message.php" "public_html/app/Models" "Message.php"
upload_file "$ROOT_DIR/app/Models/Newsletter.php" "public_html/app/Models" "Newsletter.php"
upload_file "$ROOT_DIR/app/Models/AgentRun.php" "public_html/app/Models" "AgentRun.php"

# CSS & JS (Source)
upload_file "$ROOT_DIR/resources/css/blog.css" "public_html/resources/css" "blog.css"
upload_file "$ROOT_DIR/resources/js/blog.js" "public_html/resources/js" "blog.js"
upload_file "$ROOT_DIR/resources/css/admin.css" "public_html/resources/css" "admin.css"

# Views - Public
upload_file "$ROOT_DIR/resources/views/home.blade.php" "public_html/resources/views" "home.blade.php"
upload_file "$ROOT_DIR/resources/views/contato.blade.php" "public_html/resources/views" "contato.blade.php"
upload_file "$ROOT_DIR/resources/views/sobre.blade.php" "public_html/resources/views" "sobre.blade.php"
upload_file "$ROOT_DIR/resources/views/privacidade.blade.php" "public_html/resources/views" "privacidade.blade.php"
upload_file "$ROOT_DIR/resources/views/blog/index.blade.php" "public_html/resources/views/blog" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/blog/show.blade.php" "public_html/resources/views/blog" "show.blade.php"
upload_file "$ROOT_DIR/resources/views/courses/index.blade.php" "public_html/resources/views/courses" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/courses/show.blade.php" "public_html/resources/views/courses" "show.blade.php"
upload_file "$ROOT_DIR/resources/views/student/dashboard.blade.php" "public_html/resources/views/student" "dashboard.blade.php"
upload_file "$ROOT_DIR/resources/views/sitemap.blade.php" "public_html/resources/views" "sitemap.blade.php"

# Views - Admin
upload_file "$ROOT_DIR/resources/views/admin/posts/index.blade.php" "public_html/resources/views/admin/posts" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/posts/create.blade.php" "public_html/resources/views/admin/posts" "create.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/posts/edit.blade.php" "public_html/resources/views/admin/posts" "edit.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/courses/index.blade.php" "public_html/resources/views/admin/courses" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/courses/create.blade.php" "public_html/resources/views/admin/courses" "create.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/courses/edit.blade.php" "public_html/resources/views/admin/courses" "edit.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/messages/index.blade.php" "public_html/resources/views/admin/messages" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/messages/show.blade.php" "public_html/resources/views/admin/messages" "show.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/newsletters/index.blade.php" "public_html/resources/views/admin/newsletters" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/media/index.blade.php" "public_html/resources/views/admin/media" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/users/index.blade.php" "public_html/resources/views/admin/users" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/users/edit.blade.php" "public_html/resources/views/admin/users" "edit.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/settings/index.blade.php" "public_html/resources/views/admin/settings" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/lessons/create.blade.php" "public_html/resources/views/admin/lessons" "create.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/lessons/edit.blade.php" "public_html/resources/views/admin/lessons" "edit.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/categories/index.blade.php" "public_html/resources/views/admin/categories" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/tags/index.blade.php" "public_html/resources/views/admin/tags" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/agents/index.blade.php" "public_html/resources/views/admin/agents" "index.blade.php"
upload_file "$ROOT_DIR/resources/views/admin/dashboard.blade.php" "public_html/resources/views/admin" "dashboard.blade.php"
upload_file "$ROOT_DIR/resources/views/layouts/blog.blade.php" "public_html/resources/views/layouts" "blog.blade.php"
upload_file "$ROOT_DIR/resources/views/layouts/app.blade.php" "public_html/resources/views/layouts" "app.blade.php"
upload_file "$ROOT_DIR/resources/views/layouts/guest.blade.php" "public_html/resources/views/layouts" "guest.blade.php"
upload_file "$ROOT_DIR/resources/views/layouts/navigation.blade.php" "public_html/resources/views/layouts" "navigation.blade.php"

# Auth Views
upload_file "$ROOT_DIR/resources/views/auth/login.blade.php" "public_html/resources/views/auth" "login.blade.php"
upload_file "$ROOT_DIR/resources/views/auth/register.blade.php" "public_html/resources/views/auth" "register.blade.php"
upload_file "$ROOT_DIR/resources/views/auth/forgot-password.blade.php" "public_html/resources/views/auth" "forgot-password.blade.php"
upload_file "$ROOT_DIR/resources/views/auth/reset-password.blade.php" "public_html/resources/views/auth" "reset-password.blade.php"
upload_file "$ROOT_DIR/resources/views/auth/verify-email.blade.php" "public_html/resources/views/auth" "verify-email.blade.php"
upload_file "$ROOT_DIR/resources/views/auth/confirm-password.blade.php" "public_html/resources/views/auth" "confirm-password.blade.php"

# Profile Views
upload_file "$ROOT_DIR/resources/views/profile/edit.blade.php" "public_html/resources/views/profile" "edit.blade.php"
upload_file "$ROOT_DIR/resources/views/profile/partials/delete-user-form.blade.php" "public_html/resources/views/profile/partials" "delete-user-form.blade.php"
upload_file "$ROOT_DIR/resources/views/profile/partials/update-password-form.blade.php" "public_html/resources/views/profile/partials" "update-password-form.blade.php"
upload_file "$ROOT_DIR/resources/views/profile/partials/update-profile-information-form.blade.php" "public_html/resources/views/profile/partials" "update-profile-information-form.blade.php"

# Views - Components
upload_file "$ROOT_DIR/resources/views/components/blog/post-card.blade.php" "public_html/resources/views/components/blog" "post-card.blade.php"
upload_file "$ROOT_DIR/resources/views/components/course/course-card.blade.php" "public_html/resources/views/components/course" "course-card.blade.php"
upload_file "$ROOT_DIR/resources/views/components/admin/card.blade.php" "public_html/resources/views/components/admin" "card.blade.php"
upload_file "$ROOT_DIR/resources/views/components/form/input.blade.php" "public_html/resources/views/components/form" "input.blade.php"
upload_file "$ROOT_DIR/resources/views/components/form/textarea.blade.php" "public_html/resources/views/components/form" "textarea.blade.php"
upload_file "$ROOT_DIR/resources/views/components/form/select.blade.php" "public_html/resources/views/components/form" "select.blade.php"
upload_file "$ROOT_DIR/resources/views/components/application-logo.blade.php" "public_html/resources/views/components" "application-logo.blade.php"
upload_file "$ROOT_DIR/resources/views/components/auth-session-status.blade.php" "public_html/resources/views/components" "auth-session-status.blade.php"
upload_file "$ROOT_DIR/resources/views/components/danger-button.blade.php" "public_html/resources/views/components" "danger-button.blade.php"
upload_file "$ROOT_DIR/resources/views/components/dropdown.blade.php" "public_html/resources/views/components" "dropdown.blade.php"
upload_file "$ROOT_DIR/resources/views/components/dropdown-link.blade.php" "public_html/resources/views/components" "dropdown-link.blade.php"
upload_file "$ROOT_DIR/resources/views/components/input-error.blade.php" "public_html/resources/views/components" "input-error.blade.php"
upload_file "$ROOT_DIR/resources/views/components/input-label.blade.php" "public_html/resources/views/components" "input-label.blade.php"
upload_file "$ROOT_DIR/resources/views/components/modal.blade.php" "public_html/resources/views/components" "modal.blade.php"
upload_file "$ROOT_DIR/resources/views/components/nav-link.blade.php" "public_html/resources/views/components" "nav-link.blade.php"
upload_file "$ROOT_DIR/resources/views/components/primary-button.blade.php" "public_html/resources/views/components" "primary-button.blade.php"
upload_file "$ROOT_DIR/resources/views/components/responsive-nav-link.blade.php" "public_html/resources/views/components" "responsive-nav-link.blade.php"
upload_file "$ROOT_DIR/resources/views/components/secondary-button.blade.php" "public_html/resources/views/components" "secondary-button.blade.php"
upload_file "$ROOT_DIR/resources/views/components/text-input.blade.php" "public_html/resources/views/components" "text-input.blade.php"

# Migrations
for f in $ROOT_DIR/database/migrations/*; do
    filename=$(basename "$f")
    upload_file "$f" "public_html/database/migrations" "$filename"
done

# Seeders
for f in $ROOT_DIR/database/seeders/*; do
    filename=$(basename "$f")
    upload_file "$f" "public_html/database/seeders" "$filename"
done

# Static Assets
for f in $ROOT_DIR/public/css/*; do
    filename=$(basename "$f")
    upload_file "$f" "public_html/public/css" "$filename"
done

for f in $ROOT_DIR/public/js/*; do
    filename=$(basename "$f")
    upload_file "$f" "public_html/public/js" "$filename"
done

echo "Deployment finished!"
