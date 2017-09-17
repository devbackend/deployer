/**
 * Скрипты страницы просмотра релизов.
 *
 * @author Кривонос Иван <devbackend@yandex.ru>
 */
(function(window, $) {

	$(function() {
		$('[data-release-key]').on('click', function() {
			var key = $(this).data('release-key');

			$('[data-release-content], [data-release-key]').removeClass('active');

			$('[data-release-content="' + key + '"], [data-release-key="' + key + '"]').addClass('active');
		});

		$('[data-task]').on('click', function() {
			var key = $(this).data('task');

			$('[data-task-content], [data-task]').removeClass('active');

			$('[data-task-content="' + key + '"], [data-task="' + key + '"]').addClass('active');
		});
	});
}(window, jQuery));