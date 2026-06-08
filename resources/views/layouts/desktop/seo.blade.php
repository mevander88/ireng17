        <meta name="description" content="{{ $setting->seo_description }}" />
        <meta name="keywords" content="{{ $setting->seo_meta_keywords }}" />
        <meta name="twitter:title" content="{{ $setting->seo_social_title }}">
        <meta name="twitter:description" content="{{ $setting->seo_social_description }}">
        <meta property="og:title" content="{{ $setting->seo_social_title }}">
        <meta property="og:description" content="{{ $setting->seo_social_description }}">
        <meta name="robots" content="INDEX, NOFOLLOW">
        <meta name="Content-Type" content="text/html">
        <meta name="twitter:card" content="summary">
        <meta name="og:type" content="website">
        <meta name="author" content="{{ $setting->nama_web }}">
        <meta property="og:image" content="{{ $setting->seo_banner }}">
        <link rel="icon" href="{{ $setting->favicon }}" type="image/gif">
        <meta property="og:site_name" content="{{ $setting->nama_web }}">
        <meta name="twitter:site" content="{{ $setting->nama_web }}">
        <meta name="twitter:image" content="{{ $setting->seo_banner }}">
        <meta property="og:image:alt" content="{{ $setting->nama_web }}">
        <meta name="viewport" content="width=1280">