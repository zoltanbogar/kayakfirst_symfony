set :application, "kayak"
set :domain,      "213.181.208.130"
set :user,        "root"
set :deploy_to,   "/var/www/html/kayak"
set :app_path,    "app"
set :web_path,	  "web"

set :scm,         :git
set :repository,  "git@bitbucket.org:einnovart-dev/kayakfirst.git"
set :deploy_via, :remote_cache

default_run_options[:pty] = true
ssh_options[:forward_agent] = true

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     ["vendor", "var/jwt"]
set :use_composer, true
set :update_vendors, false
set :symfony_console_path, "bin/console"


set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

#set  :use_sudo,      true
set  :keep_releases,  3

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

set :interactive_mode, false

before "deploy", :change_permissions
before "deploy:migrations", :change_permissions

desc "Change permissions before"
task :change_permissions, :roles => [ :web ] do
    sudo "chmod g+w #{deploy_to}"
end

after "deploy", :change_permissions

desc "Change permissions after"
task :change_permissions, :roles => [ :web ] do
    sudo "chown -R www-data:www-data #{deploy_to}"
#    sudo "chmod -R 777 #{deploy_to}/current/var/cache"
#    sudo "chmod -R 777 #{deploy_to}/current/var/sessions"
end

#after "deploy", "deploy:cleanup"
