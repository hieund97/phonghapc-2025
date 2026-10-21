<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($sitemaps as $sitemap)
        <sitemap>
            <loc>{{ url($sitemap) }}</loc>
            <lastmod>{{ now()->toDateString() }}</lastmod>
        </sitemap>
    @endforeach
</sitemapindex>