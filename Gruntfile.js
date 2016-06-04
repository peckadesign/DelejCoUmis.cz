module.exports = function(grunt) {
	grunt.initConfig({
		'bower-install-simple': {
			options: {
				directory: 'temp/bower/'
			},
			production: {
				options: {
					production: true,
					interactive: false
				}
			}
		},
		concat: {
			scripts: {
				src: [
					'temp/bower/jquery/jquery.min.js',
					'assets/js/main.js',
				],
				dest: 'www/js/scripts.js'
			},
			respond: {
				src: [
					'temp/bower/respond/dest/respond.min.js'
				],
				dest: 'www/js/respond.min.js'
			}
		},
		less: {
			production: {
				options: {
					sourceMap: true
				},
				files: {
					'www/styles/styles.css': 'assets/styles/styles.less'
				}
			}
		},
		uglify: {
			scripts: {
				src: 'www/js/scripts.js',
				dest: 'www/js/scripts.js'
			}
		},
		watch: {
			scripts: {
				files: ['assets/js/*.js'],
				tasks: ['scripts'],
				options: {
					spawn: false
				}
			},
			styles: {
				files: ['assets/styles/*.less'],
				tasks: ['styles'],
				options: {
					spawn: false
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-bower-install-simple');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['development']);
	grunt.registerTask('bower', ['bower-install-simple:production']);
	grunt.registerTask('scripts', ['concat:scripts', 'concat:respond']);
	grunt.registerTask('styles', ['less']);

	grunt.registerTask('production', ['bower', 'scripts', 'styles', 'uglify:scripts']);
	grunt.registerTask('development', ['bower', 'scripts', 'styles']);
};
