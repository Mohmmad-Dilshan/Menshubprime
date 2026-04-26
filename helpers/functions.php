<?php
// functions.php - Helper functions for clean URLs

function get_blog_url($slug) {
    return '/Menshubprime/blog/' . urlencode($slug);
}

function get_product_url($slug) {
    return '/Menshubprime/product/' . urlencode($slug);
}

function get_video_url($slug) {
    return '/Menshubprime/video/' . urlencode($slug);
}

function get_digital_product_url($slug) {
    return '/Menshubprime/digital-product/' . urlencode($slug);
}

/**
 * Convert various video platform URLs into embeddable format
 */
function getEmbedUrl($url) {
    // YouTube
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
        return 'https://www.youtube.com/embed/' . $id[1];
    }
    if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
        return 'https://www.youtube.com/embed/' . $id[1];
    }
    if (preg_match('/youtube\.com\/shorts\/([^\&\?\/]+)/', $url, $id)) {
        return 'https://www.youtube.com/embed/' . $id[1];
    }
    if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
        return 'https://www.youtube.com/embed/' . $id[1];
    }
    
    // Instagram
    if (preg_match('/instagram\.com\/(p|reel|tv)\/([^\&\?\/]+)/', $url, $id)) {
        return 'https://www.instagram.com/reels/' . $id[2] . '/embed/';
    }
    
    // Facebook
    if (preg_match('/facebook\.com\/.*\/videos\/([0-9]+)/', $url, $id)) {
        return 'https://www.facebook.com/plugins/video.php?href=' . urlencode($url);
    }

    // Default return original (e.g. if it is already an embed link or direct MP4)
    return $url;
}

// Use in your PHP files:
// <a href="get_blog_url($row['slug'])">title</a>
?>