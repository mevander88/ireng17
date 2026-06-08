{{-- resources/views/content/seo.blade.php --}}
<meta name="description" content="{{ $setting->seo_description }}" />
<meta name="keywords" content="{{ $setting->seo_meta_keywords }}" />
<meta name="robots" content="index, follow">
<meta name="author" content="{{ $setting->nama_web }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="Content-Type" content="text/html; charset=UTF-8">
<meta name="geo.country" content="ID">
<meta name="geo.region" content="ID">
<meta name="geo.placename" content="Indonesia">
<meta name="tgn.nation" content="Indonesia">

{{-- ✅ Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $setting->seo_social_title }}">
<meta name="twitter:description" content="{{ $setting->seo_social_description }}">
<meta name="twitter:site" content="{{ $setting->nama_web }}">
<meta name="twitter:image" content="{{ $setting->seo_banner }}">

{{-- ✅ OpenGraph (Facebook, WhatsApp, LinkedIn) --}}
<meta property="og:title" content="{{ $setting->seo_social_title }}">
<meta property="og:description" content="{{ $setting->seo_social_description }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $setting->seo_url ?? url()->current() }}">
<meta property="og:image" content="{{ $setting->seo_banner }}">
<meta property="og:image:alt" content="{{ $setting->nama_web }}">
<meta property="og:site_name" content="{{ $setting->nama_web }}">
<meta property="og:locale" content="id_ID">

{{-- ✅ Canonical & Sitemap --}}
<link rel="canonical" href="{{ url()->current() }}">
<link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

{{-- ✅ Structured Data (Schema.org) --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ $setting->nama_web }}",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/') }}?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
