<?php
/**
 * Custom Repeater Control for WordPress Customizer
 * Used for Floating Contact Channels
 *
 * @package Slatan_Design
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_Customize_Control')) {
    return;
}

/**
 * Repeater Control for Customizer
 */
class Slatan_Customizer_Repeater_Control extends WP_Customize_Control
{
    /**
     * Control type
     */
    public $type = 'slatan-repeater';

    /**
     * Fields configuration
     */
    public $fields = array();

    /**
     * Maximum items
     */
    public $max_items = 20;

    /**
     * Button labels
     */
    public $button_labels = array();

    /**
     * Constructor
     */
    public function __construct($manager, $id, $args = array())
    {
        $this->fields = isset($args['fields']) ? $args['fields'] : array();
        $this->max_items = isset($args['max_items']) ? $args['max_items'] : 20;
        $this->button_labels = wp_parse_args(
            isset($args['button_labels']) ? $args['button_labels'] : array(),
            array(
                'add' => __('Add Channel', 'slatan-design'),
                'remove' => __('Remove', 'slatan-design'),
                'toggle' => __('Toggle', 'slatan-design'),
            )
        );
        parent::__construct($manager, $id, $args);
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue()
    {
        wp_enqueue_style(
            'slatan-customizer-repeater',
            get_template_directory_uri() . '/css/admin-floating-contact.css',
            array(),
            defined('_S_VERSION') ? _S_VERSION : '1.0.0'
        );

        wp_enqueue_script(
            'slatan-customizer-repeater',
            get_template_directory_uri() . '/js/admin-floating-contact.js',
            array('jquery', 'customize-controls', 'wp-color-picker'),
            defined('_S_VERSION') ? _S_VERSION : '1.0.0',
            true
        );

        wp_enqueue_style('wp-color-picker');
    }

    /**
     * Render control content
     */
    public function render_content()
    {
        $values = json_decode($this->value(), true);
        if (!is_array($values)) {
            $values = array();
        }
        ?>
        <div class="slatan-repeater-control" data-max-items="<?php echo esc_attr($this->max_items); ?>">
            <?php if (!empty($this->label)): ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php endif; ?>

            <?php if (!empty($this->description)): ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>

            <input type="hidden" class="slatan-repeater-value" <?php $this->link(); ?>
                value="<?php echo esc_attr($this->value()); ?>">

            <div class="slatan-repeater-items">
                <?php
                if (!empty($values)) {
                    foreach ($values as $index => $item) {
                        $this->render_item($index, $item);
                    }
                }
                ?>
            </div>

            <button type="button" class="button slatan-repeater-add">
                <span class="dashicons dashicons-plus-alt2"></span>
                <?php echo esc_html($this->button_labels['add']); ?>
            </button>

            <!-- Template for new items -->
            <script type="text/template" class="slatan-repeater-template">
                        <?php $this->render_item('__INDEX__', array()); ?>
                    </script>
        </div>
        <?php
    }

    /**
     * Render a single repeater item
     */
    private function render_item($index, $values)
    {
        $is_enabled = isset($values['enable']) ? $values['enable'] : true;
        ?>
        <div class="slatan-repeater-item<?php echo $is_enabled ? '' : ' is-disabled'; ?>"
            data-index="<?php echo esc_attr($index); ?>">
            <div class="slatan-repeater-item-header">
                <span class="slatan-repeater-item-title">
                    <?php
                    $label = isset($values['label']) && !empty($values['label'])
                        ? $values['label']
                        : sprintf(__('Channel %s', 'slatan-design'), is_numeric($index) ? $index + 1 : '#');
                    echo esc_html($label);
                    ?>
                </span>
                <div class="slatan-repeater-item-actions">
                    <button type="button" class="slatan-repeater-toggle"
                        title="<?php echo esc_attr($this->button_labels['toggle']); ?>">
                        <span class="dashicons dashicons-<?php echo $is_enabled ? 'visibility' : 'hidden'; ?>"></span>
                    </button>
                    <button type="button" class="slatan-repeater-expand">
                        <span class="dashicons dashicons-arrow-down-alt2"></span>
                    </button>
                    <button type="button" class="slatan-repeater-remove"
                        title="<?php echo esc_attr($this->button_labels['remove']); ?>">
                        <span class="dashicons dashicons-trash"></span>
                    </button>
                </div>
            </div>

            <div class="slatan-repeater-item-content" style="display: none;">
                <input type="hidden" class="slatan-field" data-field="enable" value="<?php echo $is_enabled ? '1' : '0'; ?>">

                <?php foreach ($this->fields as $field_id => $field): ?>
                    <?php $field_value = isset($values[$field_id]) ? $values[$field_id] : (isset($field['default']) ? $field['default'] : ''); ?>

                    <div class="slatan-repeater-field slatan-field-<?php echo esc_attr($field['type']); ?>">
                        <label><?php echo esc_html($field['label']); ?></label>

                        <?php if (isset($field['description'])): ?>
                            <span class="description"><?php echo esc_html($field['description']); ?></span>
                        <?php endif; ?>

                        <?php switch ($field['type']):
                            case 'text':
                            case 'url': ?>
                                <input type="<?php echo esc_attr($field['type']); ?>" class="slatan-field widefat"
                                    data-field="<?php echo esc_attr($field_id); ?>" value="<?php echo esc_attr($field_value); ?>"
                                    placeholder="<?php echo esc_attr(isset($field['placeholder']) ? $field['placeholder'] : ''); ?>">
                                <?php break;

                            case 'color': ?>
                                <input type="text" class="slatan-field slatan-color-picker" data-field="<?php echo esc_attr($field_id); ?>"
                                    value="<?php echo esc_attr($field_value); ?>"
                                    data-default-color="<?php echo esc_attr(isset($field['default']) ? $field['default'] : '#0073aa'); ?>">
                                <?php break;

                            case 'select': ?>
                                <select class="slatan-field widefat" data-field="<?php echo esc_attr($field_id); ?>">
                                    <?php foreach ($field['choices'] as $choice_value => $choice_label): ?>
                                        <option value="<?php echo esc_attr($choice_value); ?>" <?php selected($field_value, $choice_value); ?>>
                                            <?php echo esc_html($choice_label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php break;
                        endswitch; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
