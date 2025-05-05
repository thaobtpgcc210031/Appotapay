<div class="changelog_container">
    <?php
    $continental_restaurant_changelog_entries = get_changelog_from_readme();
    if (!empty($continental_restaurant_changelog_entries)) :
        foreach ($continental_restaurant_changelog_entries as $continental_restaurant_entry) :
            $continental_restaurant_version = esc_html($continental_restaurant_entry[1]);
            $continental_restaurant_date = esc_html($continental_restaurant_entry[2]);
            $continental_restaurant_details = explode("\n", trim($continental_restaurant_entry[3]));
            ?>
            <div class="changelog_element">
                <span class="theme_version">
                    <strong><?php echo 'v' . $continental_restaurant_version; ?></strong>
                    <?php echo 'Release date: ' . $continental_restaurant_date; ?>
                    <span class="dashicons dashicons-arrow-down-alt2"></span>
                </span>

                <div class="changelog_details" style="display: none;">
                    <ul>
                        <?php foreach ($continental_restaurant_details as $continental_restaurant_detail) : ?>
                            <li><?php echo esc_html(trim($continental_restaurant_detail, "- \t")); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php
        endforeach;
    else :
        ?>
        <p><?php esc_html_e('No changelog available.', 'continental-restaurant'); ?></p>
    <?php endif; ?>
</div>