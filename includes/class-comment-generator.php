<?php
class ACG_Comment_Generator {
    public function __construct() {
        add_action('acg_daily_comments_event', [$this, 'generate_comments']);
        
        if (!wp_next_scheduled('acg_daily_comments_event')) {
            wp_schedule_event(time(), 'twicedaily', 'acg_daily_comments_event');
        }
    }

    public function generate_comments() {
        $posts = $this->get_all_posts();
        $batch_size = apply_filters('acg_batch_size', 50);

        foreach (array_chunk($posts, $batch_size) as $post_group) {
            $this->process_batch($post_group);
        }
    }

    private function process_batch($posts) {
        foreach ($posts as $post) {
            $comment_data = [
                'comment_post_ID'  => $post->ID,
                'comment_author'   => $this->get_random_name(),
                'comment_email'    => $this->get_random_email(),
                'comment_content'  => $this->get_random_comment(),
                'comment_approved' => 1,
                'comment_type'     => 'comment'
            ];

            wp_insert_comment(wp_slash($comment_data));
        }
    }

    private function get_all_posts() {
        return get_posts([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids'
        ]);
    }

    private function get_random_name() {
        $data = ACG_Data_Manager::get_random_data('names', 1);
        return $data[0]['value'] ?? 'Anonymous';
    }

    // متدهای مشابه برای ایمیل و کامنت
}
