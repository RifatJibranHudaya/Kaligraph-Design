<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
  <!-- Homepage -->
  <url>
    <loc>{{ url('/') }}</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>
  
  <!-- Katalog -->
  <url>
    <loc>{{ route('katalog') }}</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
  
  <!-- Portfolio -->
  <url>
    <loc>{{ route('portfolio.index') }}</loc>
    <lastmod>{{ now()->format('Y-m-d') }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  
  <!-- Categories -->
  @foreach($categories as $category)
  <url>
    <loc>{{ route('katalog.kategori', $category->slug) }}</loc>
    <lastmod>{{ $category->updated_at->format('Y-m-d') }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
  @endforeach
  
  <!-- Products (top 100) -->
  @foreach($products as $product)
  <url>
    <loc>{{ route('katalog.detail', $product->slug) }}</loc>
    <lastmod>{{ $product->updated_at->format('Y-m-d') }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
  </url>
  @endforeach
  
</urlset>
