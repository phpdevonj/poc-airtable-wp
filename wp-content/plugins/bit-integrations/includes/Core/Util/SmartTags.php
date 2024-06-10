<?php

namespace BitCode\FI\Core\Util;
use BitCode\FI\Core\Util\IpTool;

/**
 * handling Special mail-tags
 *
 * @since 1.0.0
 */

final class SmartTags {
    public static function getPostUserData( $isReferer ) {
        $post = [];
        if ( $isReferer && isset( $_SERVER['HTTP_REFERER'] ) ) {
            $postId = url_to_postid( $_SERVER['HTTP_REFERER'] );
        } else {
            $postId = url_to_postid( $_SERVER['REQUEST_URI'] );
        }

        if ( $postId ) {
            $post = get_post( $postId, 'OBJECT' );
        }

        $user = wp_get_current_user();
        $user_roles = $user->roles;

        if ( !is_wp_error( $user_roles ) && count( $user_roles ) > 0 ) {
            $user->current_user_role = $user_roles[0];
        }

        $postAuthorInfo = [];
        if ( isset( $post->post_author ) ) {
            $postAuthorInfo = get_user_by( 'ID', $post->post_author );
        }

        return ['user' => $user, 'post' => $post, 'post_author_info' => $postAuthorInfo];

    }

    public static function getSmartTagValue( $key, $isReferer = false ) {
        $data = static::getPostUserData( $isReferer );
        $userDetail = IpTool::getUserDetail();
        $device = explode( '|', $userDetail['device'] );

        if ( is_array( $device ) ) {
            $browser = $device[0];
            $operating = $device[1];
        }

        $smartTags = [
            '_bi_current_time'       => date( 'Y-m-d H:i:s' ),
            '_bi_admin_email'        => get_bloginfo( 'admin_email' ),
            '_bi_date_default'       => wp_date( get_option( 'date_format' ) ),
            '_bi_date.m/d/y'         => wp_date( 'm/d/y' ),
            '_bi_date.d/m/y'         => wp_date( 'd/m/y' ),
            '_bi_date.y/m/d'         => wp_date( 'y/m/d' ),
            '_bi_time'               => wp_date( get_option( 'time_format' ) ),
            '_bi_weekday'            => wp_date( 'l' ),
            '_bi_http_referer_url'   => isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '',
            '_bi_ip_address'         => IpTool::getIP(),
            '_bi_browser_name'       => isset( $browser ) ? $browser : '',
            '_bi_operating_system'   => isset( $operating ) ? $operating : '',
            '_bi_random_digit_num'   => time(),
            '_bi_user_id'            => ( isset( $data['user']->ID ) ? $data['user']->ID : " " ),
            '_bi_user_first_name'    => ( isset( $data['user']->first_name ) ? $data['user']->first_name : " " ),
            '_bi_user_last_name'     => ( isset( $data['user']->last_name ) ? $data['user']->last_name : " " ),
            '_bi_user_display_name'  => ( isset( $data['user']->display_name ) ? $data['user']->display_name : " " ),
            '_bi_user_nice_name'     => ( isset( $data['user']->user_nicename ) ? $data['user']->user_nicename : " " ),
            '_bi_user_login_name'    => ( isset( $data['user']->user_login ) ? $data['user']->user_login : " " ),
            '_bi_user_email'         => ( isset( $data['user']->user_email ) ? $data['user']->user_email : " " ),
            '_bi_user_url'           => ( isset( $data['user']->user_url ) ? $data['user']->user_url : " " ),
            '_bi_current_user_role'  => ( isset( $data['user']->current_user_role ) ? $data['user']->current_user_role : " " ),
            '_bi_author_id'          => ( isset( $data['post_author_info']->ID ) ? $data['post_author_info']->ID : " " ),
            '_bi_author_display'     => ( isset( $data['post_author_info']->display_name ) ? $data['post_author_info']->display_name : " " ),
            '_bi_author_email'       => ( isset( $data['post_author_info']->user_email ) ? $data['post_author_info']->user_email : " " ),
            '_bi_site_title'         => get_bloginfo( 'name' ),
            '_bi_site_description'   => get_bloginfo( 'description' ),
            '_bi_site_url'           => get_bloginfo( 'url' ),
            '_bi_wp_local_codes'     => get_bloginfo( 'language' ),
            '_bi_post_id'            => ( is_object( $data['post'] ) ? $data['post']->ID : "" ),
            '_bi_post_name'          => ( is_object( $data['post'] ) ? $data['post']->post_name : "" ),
            '_bi_post_title'         => ( is_object( $data['post'] ) ? $data['post']->post_title : "" ),
            '_bi_post_date'          => ( is_object( $data['post'] ) ? $data['post']->post_date : "" ),
            '_bi_post_modified_date' => ( is_object( $data['post'] ) ? $data['post']->post_modified : "" ),
            '_bi_post_url'           => ( is_object( $data['post'] ) ? get_permalink( $data['post']->ID ) : "" ),
        ];
        if ( isset( $smartTags[$key] ) ) {
            return $smartTags[$key];
        } else {
            return '';
        }

    }
}
