module.exports = {
    apps : [
        {
            name: "laravel-queue",
            script: "./artisan",
            args: "queue:work --tries=3",
            instances: "1",
            autorestart: true,
            watch: false,
            max_memory_restart: "1G",
            env: {
                NODE_ENV: "production"  // Adjust as needed
            },
            env_development: {
                NODE_ENV: "development"
            }
        }
    ]
};
