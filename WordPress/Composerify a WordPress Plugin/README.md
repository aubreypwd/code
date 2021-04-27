# cmd.sh

This command is super-specific to my setup and Local by Flywheel. But what it will do is take a direct path to a plugin e.g. `/Users/aubreypwd/Local Sites/site/app/public/wp-content/plugin/path-to-plugin` and will "composerify" it by adding the plugin path (relative) to `.gitignore` and removing it from Git. You will need to add it via `composer.json` at that point. It just allowed me to right click the path in Sublime and paste it in, and it would delete the file and add it to .gitignore for me.
