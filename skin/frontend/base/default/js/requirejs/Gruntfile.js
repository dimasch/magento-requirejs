/**
 * Gruntfile.js
 */

module.exports = function(grunt) {

  var //requirejs = require("requirejs"),
  exec = require("child_process").exec,
  fatal = grunt.fail.fatal,
  log = grunt.log,
  verbose = grunt.verbose;
  // Your r.js build configuration
  //buildConfigMain = grunt.file.readJSON("app.build.js");

    // Transfer the build folder to the right location on the server
    grunt.registerTask(
        "transfer",
        "Transfer the build folder to ./website/build and remove it",
        function() {
            var done = this.async();
            // Delete the build folder locally after transferring
            exec("rsync -rlv --delete --delete-after ./build ./website && rm -rf ./build",
            function( err, stdout, stderr ) {
                if ( err ) {
                    fatal("Problem with rsync: " + err + " " + stderr );
                }
                verbose.writeln( stdout );
                log.ok("Rsync complete.");
                done();
            });
        }
    );


    // Build static assets using r.js
    grunt.registerTask(
        "build-common",
        "Run the r.js build script",
        function() {
            var done = this.async();
            exec("r.js -o mainConfigFile=common.js out=dist/common.js include=common optimize=uglify2 exclude=",
            function( err, stdout, stderr ) {
                if ( err ) {
                    fatal("Problem with build: " + err + " " + stderr );
                }
                verbose.writeln( stdout );
                log.ok("Common build complete.");
                done();
            });
        }
    );

    grunt.registerTask(
        "build-home",
        "Run the r.js build script",
        function() {
            var done = this.async();
            exec("r.js -o mainConfigFile=common.js out=dist/home.js include=home optimize=uglify2 exclude=common",
            function( err, stdout, stderr ) {
                if ( err ) {
                    fatal("Problem with build: " + err + " " + stderr );
                }
                verbose.writeln( stdout );
                log.ok("Home build complete.");
                done();
            });

        }
    );

    grunt.registerTask('build', ["build-common", "build-home"]);
    grunt.registerTask('default', ["build"]);
};


