/**
 * Floating Contact Repeater - Admin JavaScript
 * Handles the Customizer repeater control interactions
 *
 * @package Slatan_Design
 */

(function($) {
    'use strict';

    // Wait for Customizer to be ready
    wp.customize.bind('ready', function() {
        initRepeaterControls();
    });

    /**
     * Initialize all repeater controls
     */
    function initRepeaterControls() {
        $('.slatan-repeater-control').each(function() {
            var $control = $(this);
            initSingleRepeater($control);
        });
    }

    /**
     * Initialize a single repeater control
     */
    function initSingleRepeater($control) {
        var $input = $control.find('.slatan-repeater-value');
        var $items = $control.find('.slatan-repeater-items');
        var $addBtn = $control.find('.slatan-repeater-add');
        var template = $control.find('.slatan-repeater-template').html();
        var maxItems = parseInt($control.data('max-items')) || 20;
        var itemIndex = $items.find('.slatan-repeater-item').length;

        // Initialize color pickers on existing items
        initColorPickers($items);

        // Add new item
        $addBtn.on('click', function(e) {
            e.preventDefault();

            if ($items.find('.slatan-repeater-item').length >= maxItems) {
                alert('Maximum ' + maxItems + ' items allowed.');
                return;
            }

            var newItem = template.replace(/__INDEX__/g, itemIndex);
            var $newItem = $(newItem);
            $items.append($newItem);
            
            // Initialize color picker on new item
            initColorPickers($newItem);
            
            // Open the new item
            $newItem.find('.slatan-repeater-item-content').slideDown(200);
            $newItem.find('.slatan-repeater-expand .dashicons')
                .removeClass('dashicons-arrow-down-alt2')
                .addClass('dashicons-arrow-up-alt2');

            itemIndex++;
            updateValue($control);
        });

        // Toggle item enable/disable
        $items.on('click', '.slatan-repeater-toggle', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.slatan-repeater-item');
            var $icon = $(this).find('.dashicons');
            var $enableField = $item.find('[data-field="enable"]');
            
            if ($item.hasClass('is-disabled')) {
                $item.removeClass('is-disabled');
                $enableField.val('1');
                $icon.removeClass('dashicons-hidden').addClass('dashicons-visibility');
            } else {
                $item.addClass('is-disabled');
                $enableField.val('0');
                $icon.removeClass('dashicons-visibility').addClass('dashicons-hidden');
            }
            
            updateValue($control);
        });

        // Expand/collapse item
        $items.on('click', '.slatan-repeater-expand', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.slatan-repeater-item');
            var $content = $item.find('.slatan-repeater-item-content');
            var $icon = $(this).find('.dashicons');

            if ($content.is(':visible')) {
                $content.slideUp(200);
                $icon.removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
            } else {
                $content.slideDown(200);
                $icon.removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
            }
        });

        // Remove item
        $items.on('click', '.slatan-repeater-remove', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.slatan-repeater-item');
            
            if (confirm('Are you sure you want to remove this channel?')) {
                $item.slideUp(200, function() {
                    $(this).remove();
                    updateValue($control);
                });
            }
        });

        // Update value on field change
        $items.on('change keyup', '.slatan-field', function() {
            // Update title if label changes
            if ($(this).data('field') === 'label') {
                var $item = $(this).closest('.slatan-repeater-item');
                var label = $(this).val() || 'Channel';
                $item.find('.slatan-repeater-item-title').text(label);
            }
            
            updateValue($control);
        });

        // Make items sortable
        if ($.fn.sortable) {
            $items.sortable({
                handle: '.slatan-repeater-item-header',
                placeholder: 'slatan-repeater-placeholder',
                update: function() {
                    updateValue($control);
                }
            });
        }
    }

    /**
     * Initialize color pickers
     */
    function initColorPickers($container) {
        $container.find('.slatan-color-picker').each(function() {
            if (!$(this).hasClass('wp-color-picker')) {
                $(this).wpColorPicker({
                    change: function() {
                        // Trigger change after a small delay for wpColorPicker
                        var $this = $(this);
                        setTimeout(function() {
                            $this.trigger('change');
                        }, 100);
                    }
                });
            }
        });
    }

    /**
     * Update the hidden input value
     */
    function updateValue($control) {
        var $input = $control.find('.slatan-repeater-value');
        var $items = $control.find('.slatan-repeater-item');
        var values = [];

        $items.each(function() {
            var $item = $(this);
            var itemData = {};

            $item.find('.slatan-field').each(function() {
                var field = $(this).data('field');
                var value = $(this).val();
                
                // Handle color picker
                if ($(this).hasClass('slatan-color-picker')) {
                    value = $(this).wpColorPicker('color') || $(this).val();
                }
                
                // Convert enable to boolean
                if (field === 'enable') {
                    value = value === '1' || value === 'true';
                }
                
                itemData[field] = value;
            });

            values.push(itemData);
        });

        $input.val(JSON.stringify(values)).trigger('change');
    }

})(jQuery);
