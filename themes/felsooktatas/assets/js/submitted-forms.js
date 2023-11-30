jQuery(document).ready(function ($) {
    // Loop through each message container to decide whether to show the toggle button
    $('.message-container').each(function () {
        var $messageContainer = $(this);
        var $toggleButton = $messageContainer.closest('tr').find('.toggle-button');

        if ($messageContainer.text().trim().length <= 15) {
            $toggleButton.addClass('hidden'); // Hide the button if the text length is 15 or less
        } else {
            $toggleButton.removeClass('hidden'); // Otherwise, show the button
        }
    });

    $('.toggle-button').on('click', function () {
        var $messageContainer = $(this).closest('tr').find('.message-container');
        $messageContainer.toggleClass('clipped-text');

        var isClipped = $messageContainer.hasClass('clipped-text');
        $(this).text(isClipped ? localizedText['show_more'] : localizedText['show_less']);
    });
});
