<?php
/**
 * MENSHUB PRIME - Fix NULL Blog Slugs
 * Run this ONCE to fix existing blogs with missing slugs
 * Then DELETE this file for security.
 */
require_once __DIR__ . '/src/bootstrap.php';

echo "<pre style='font-family:monospace; background:#111; color:#0f0; padding:20px; font-size:14px;'>";
echo "=== MENSHUB PRIME - Blog Slug Fixer ===\n\n";

// Find all blogs with empty/null slug
$q = mysqli_query($conn, "SELECT id, title, slug FROM blogs WHERE slug IS NULL OR slug = '' ORDER BY id ASC");
$count = mysqli_num_rows($q);

if ($count === 0) {
    echo "✅ All blogs already have slugs! No fix needed.\n";
    echo "\n=== Listing ALL blog slugs for verification ===\n\n";
    $all = mysqli_query($conn, "SELECT id, title, slug, status FROM blogs ORDER BY id DESC");
    while ($r = mysqli_fetch_assoc($all)) {
        $status_icon = ($r['status'] === 'active') ? '🟢' : '🔴';
        echo "{$status_icon} ID:{$r['id']} | Slug: [{$r['slug']}] | Title: {$r['title']}\n";
    }
} else {
    echo "⚠️  Found {$count} blog(s) with missing slugs. Fixing...\n\n";
    
    $fixed = 0;
    $errors = 0;
    
    while ($row = mysqli_fetch_assoc($q)) {
        $id = $row['id'];
        $title = $row['title'];
        
        // Generate slug from title
        $raw_slug = strtolower(trim($title));
        $raw_slug = preg_replace('/[^a-z0-9\s-]/', '', $raw_slug);
        $raw_slug = preg_replace('/[\s-]+/', '-', $raw_slug);
        $raw_slug = trim($raw_slug, '-');
        $raw_slug = $raw_slug ?: 'blog-' . $id;
        
        // Make unique
        $base_slug = $raw_slug;
        $counter = 1;
        $check_slug = $raw_slug;
        while (mysqli_num_rows(mysqli_query($conn, "SELECT id FROM blogs WHERE slug='$check_slug' AND id != $id")) > 0) {
            $check_slug = $base_slug . '-' . $counter;
            $counter++;
        }
        $final_slug = mysqli_real_escape_string($conn, $check_slug);
        
        // Update the blog
        $update = mysqli_query($conn, "UPDATE blogs SET slug='$final_slug' WHERE id=$id");
        
        if ($update) {
            echo "✅ Fixed ID:{$id} → slug: [{$final_slug}] | Title: {$title}\n";
            echo "   🔗 URL will be: /blog/{$final_slug}\n\n";
            $fixed++;
        } else {
            echo "❌ ERROR fixing ID:{$id} - " . mysqli_error($conn) . "\n";
            $errors++;
        }
    }
    
    echo "\n=== SUMMARY ===\n";
    echo "✅ Fixed: {$fixed}\n";
    echo "❌ Errors: {$errors}\n";
    echo "\n=== ALL BLOGS (After Fix) ===\n\n";
    
    $all = mysqli_query($conn, "SELECT id, title, slug, status FROM blogs ORDER BY id DESC");
    while ($r = mysqli_fetch_assoc($all)) {
        $status_icon = ($r['status'] === 'active') ? '🟢' : '🔴';
        echo "{$status_icon} ID:{$r['id']} | Slug: [{$r['slug']}] | Title: {$r['title']}\n";
    }
}

echo "\n\n⚠️  SECURITY: DELETE this file after use!\n";
echo "</pre>";
?>
