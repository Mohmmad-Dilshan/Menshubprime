<?php
function getBrandInfo($url, $custom_name = '') {
    $url = strtolower($url);
    
    if (strpos($url, 'amazon') !== false) {
        return [
            'name' => 'Amazon',
            'icon' => 'fab fa-amazon',
            'color' => '#ff9900',
            'slug' => 'amazon'
        ];
    } elseif (strpos($url, 'flipkart') !== false) {
        return [
            'name' => 'Flipkart',
            'icon' => 'fas fa-shopping-cart',
            'color' => '#2874f0',
            'slug' => 'flipkart'
        ];
    } elseif (strpos($url, 'myntra') !== false) {
        return [
            'name' => 'Myntra',
            'icon' => 'fas fa-shopping-bag',
            'color' => '#ff3f6c',
            'slug' => 'myntra'
        ];
    } elseif (strpos($url, 'ajio') !== false) {
        return [
            'name' => 'Ajio',
            'icon' => 'fas fa-tshirt',
            'color' => '#2c333e',
            'slug' => 'ajio'
        ];
    }
    
    return [
        'name' => $custom_name ?: 'Other Store',
        'icon' => 'fas fa-external-link-alt',
        'color' => '#64748b',
        'slug' => 'other'
    ];
}
?>
