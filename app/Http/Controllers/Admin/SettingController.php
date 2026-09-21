<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\ProjectSetting;
use App\Services\ActivityLogger;
use App\Services\CloudinaryService;
use App\Support\MediaUrl;
use App\Services\LanguageRegistry;
use App\Services\MultilingualSettings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function __construct(
        private readonly CloudinaryService $cloudinaryService,
        private readonly MultilingualSettings $multilingual,
        private readonly LanguageRegistry $languages,
        private readonly \App\Services\SiteContentService $siteContent,
    ) {}

    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = ProjectSetting::query()->get()->pluck('setting_value', 'setting_key');

        $videoBlocks = [
            'story_intro' => $this->siteContent->video('story.intro.video', 'https://www.youtube.com/embed/7PB6Tn2pyE8'),
            'story_vision' => $this->siteContent->video('story.vision.video', 'https://www.youtube.com/embed/8nVnuZSauE8'),
            'story_mission' => $this->siteContent->video('story.mission.video', 'https://www.youtube.com/embed/bIC2_Dko3xk'),
            'story_values' => $this->siteContent->video('story.values.video', 'https://www.youtube.com/embed/T8MfqRZlsFo'),
            'wholesale_testimonials' => $this->siteContent->video('wholesale.testimonials.video', 'assets/images/695_1616455d94684594acbf7eb51378dc5c.HD-720p-1.6Mbps-11675358.mp4', 'assets/images/590_9082be5215a852be1026974487789ffc_2000x.png'),
            'home_featured' => $this->siteContent->video('home.featured.video', 'assets/media/espresso_brew_desktop.mp4', 'assets/images/s54/espresso_brewtorial_desktop.jpg'),
        ];

        $bannerBlocks = [
            'home_hero' => [
                'image_key' => 'home.hero.banner',
                'name' => 'Banner Trang Chủ (Homepage)',
                'page' => '/',
                'url' => $this->siteContent->image('home.hero.banner', asset('assets/images/s54/hero_banner_s54.png')),
                'default_image' => asset('assets/images/s54/hero_banner_s54.png'),
                'title_key' => 'home.hero.title',
                'title' => $this->siteContent->value('home.hero.title') ?? 'Vietnamese Coffee. Made for the World.',
                'subtitle_key' => 'home.hero.subtitle',
                'subtitle' => $this->siteContent->value('home.hero.subtitle') ?? 'Discover bold Vietnamese coffee, crafted for modern coffee lovers.',
            ],
            'story_hero' => [
                'image_key' => 'story.hero.banner',
                'name' => 'Banner Trang Giới Thiệu (Our Story)',
                'page' => '/our-story',
                'url' => $this->siteContent->image('story.hero.banner', asset('client-assets/images/s54/story_hero_heritage.jpg')),
                'default_image' => asset('client-assets/images/s54/story_hero_heritage.jpg'),
                'badge_key' => 'story.hero.badge',
                'badge' => $this->siteContent->value('story.hero.badge') ?? 'S54 COFFEE • VIETNAMESE COFFEE. MADE FOR THE WORLD.',
                'title_key' => 'story.hero.title',
                'title' => $this->siteContent->value('story.hero.title') ?? 'Hành Trình Tinh Hoa Cà Phê Việt & Sứ Mệnh 54 Dân Tộc',
                'subtitle_key' => 'story.hero.lead',
                'subtitle' => $this->siteContent->value('story.hero.lead') ?? 'Tự hào mang tên gọi kết hợp giữa hình ảnh dải đất hình chữ S và 54 dân tộc anh em, S54 Coffee ra đời với sứ mệnh nâng tầm hạt cà phê Robusta và Arabica từ thủ phủ Tây Nguyên vươn tầm quốc tế theo phương châm "New Coffee, New Income".',
            ],
            'wholesale_hero' => [
                'image_key' => 'wholesale.hero.banner',
                'name' => 'Banner Bán Sỉ & Khách Hàng Doanh Nghiệp (Wholesale B2B)',
                'page' => '/wholesale',
                'url' => $this->siteContent->image('wholesale.hero.banner', asset('assets/images/785_1-wholesale-page-banner-desktop-2_2560x.jpg')),
                'default_image' => asset('assets/images/785_1-wholesale-page-banner-desktop-2_2560x.jpg'),
                'title_key' => 'wholesale.hero.title',
                'title' => $this->siteContent->value('wholesale.hero.title') ?? 'Bán Sỉ & Doanh Nghiệp?',
                'subtitle_key' => 'wholesale.hero.subtitle',
                'subtitle' => $this->siteContent->value('wholesale.hero.subtitle') ?? 'Chúng tôi không chỉ là nhà cung cấp cà phê, chúng tôi là đối tác chiến lược mang đến giải pháp toàn diện và hỗ trợ vượt trội cho doanh nghiệp của bạn.',
            ],
            'blog_hero' => [
                'image_key' => 'blog.hero.banner',
                'name' => 'Banner Cẩm Nang & Tin Tức (Blog)',
                'page' => '/tin-tuc',
                'url' => $this->siteContent->image('blog.hero.banner', asset('client-assets/images/s54/story_roasting_master.jpg')),
                'default_image' => asset('client-assets/images/s54/story_roasting_master.jpg'),
                'title_key' => 'blog.hero.title',
                'title' => $this->siteContent->value('blog.hero.title') ?? 'Cẩm Nang & Câu Chuyện Cà Phê',
                'subtitle_key' => 'blog.hero.subtitle',
                'subtitle' => $this->siteContent->value('blog.hero.subtitle') ?? 'Kiến thức pha chế, bí quyết bảo quản và hành trình khám phá các vùng trồng cà phê Việt Nam.',
            ],
            'catalog_hero' => [
                'image_key' => 'catalog.hero.banner',
                'name' => 'Banner Cửa Hàng / Bộ Sưu Tập (Shop / Catalog)',
                'page' => '/collections',
                'url' => $this->siteContent->image('catalog.hero.banner', ''),
                'default_image' => '',
                'title_key' => 'catalog.hero.title',
                'title' => $this->siteContent->value('catalog.hero.title') ?? 'Bộ Sưu Tập Cà Phê S54',
                'subtitle_key' => 'catalog.hero.subtitle',
                'subtitle' => $this->siteContent->value('catalog.hero.subtitle') ?? '100% Cà phê nguyên chất tuyển chọn từ Đắk Lắk & Cầu Đất, rang mộc công nghệ cao.',
            ],
            'contact_hero' => [
                'image_key' => 'contact.hero.banner',
                'name' => 'Banner Trang Liên Hệ (Contact Us)',
                'page' => '/vi/lien-he',
                'url' => $this->siteContent->image('contact.hero.banner', asset('client-assets/images/s54/story_hero_heritage.jpg')),
                'default_image' => asset('client-assets/images/s54/story_hero_heritage.jpg'),
                'badge_key' => 'contact.hero.badge',
                'badge' => $this->siteContent->value('contact.hero.badge') ?? 'KẾT NỐI VỚI CHÚNG TÔI • S54 COFFEE',
                'title_key' => 'contact.hero.title',
                'title' => $this->siteContent->value('contact.hero.title') ?? 'Liên Hệ & Hợp Tác Cùng S54 Coffee',
                'subtitle_key' => 'contact.hero.lead',
                'subtitle' => $this->siteContent->value('contact.hero.lead') ?? 'Quý khách hàng, đối tác đại lý hoặc doanh nghiệp có nhu cầu tư vấn sản phẩm, gia công OEM hoặc trải nghiệm cà phê trực tiếp xin vui lòng kết nối với chúng tôi qua thông tin bên dưới.',
            ],
        ];

        $rawFooter = $settings->get('footer_settings');
        $footerSettings = is_array($rawFooter) ? $rawFooter : [];
        $footerDefaults = [
            'company_name' => 'CÔNG TY TNHH GIẢI PHÁP TỐT',
            'tagline' => '"New Coffee, New Income" — Tinh hoa cà phê Việt vang danh thương trường từ năm 2017',
            'address' => 'Số 32, Đường 16, Manhattan, Vinhomes Grand Park, Phường Long Bình, TP. Thủ Đức, TP. Hồ Chí Minh',
            'hotline' => '0911.833.911 - 0933.873.873',
            'email' => 'info@goodsolutions.com.vn',
            'website' => 'goodsolutions.com.vn',
            'website_url' => 'https://goodsolutions.com.vn',
            'col2_title' => 'Sản Phẩm S54',
            'col3_title' => 'Về S54 & Dịch Vụ',
            'col4_title' => 'Đăng Ký Nhận Ưu Đãi',
            'newsletter_desc' => 'Nhận ngay voucher ưu đãi 15% cho đơn hàng đầu tiên cùng cẩm nang pha chế độc quyền từ S54 Coffee.',
            'copyright' => '© ' . date('Y') . ' <strong>S54 COFFEE</strong> by <strong>Good Solutions Co., Ltd</strong>. Giữ toàn quyền bản quyền.',
        ];
        $footerSettings = array_merge($footerDefaults, array_filter($footerSettings, fn ($v) => $v !== null && $v !== ''));

        return view('admin.settings.index', [
            'settings' => $settings,
            'videoBlocks' => $videoBlocks,
            'bannerBlocks' => $bannerBlocks,
            'footerSettings' => $footerSettings,
            'multilingualSettings' => $this->multilingual->get(),
            'contentLanguages' => auth()->user()?->isSuperAdmin()
                ? Language::query()->where('is_active', true)->orderBy('sort_order')->orderBy('id')->get()
                : collect(),
        ]);
    }

    /**
     * Update the website settings.
     */
    public function update(Request $request)
    {
        if ($request->has('multilingual') && ! $request->user()?->isSuperAdmin()) {
            abort(403, 'Chỉ Superadmin được thay đổi cấu hình đa ngôn ngữ.');
        }

        $rules = [
            'shop_name' => 'required|string|max:255',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,ico,cur|max:5120',
            'favicon' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,ico,cur|max:5120',
            'logo_url' => 'nullable|string|max:255',
            'favicon_url' => 'nullable|string|max:255',
            'contact.phone' => 'nullable|string|max:20',
            'contact.email' => 'nullable|email|max:255',
            'contact.address' => 'nullable|string|max:500',
            'contact.google_map_url' => 'nullable|string|max:2000',
            'contact.branches' => 'nullable|array',
            'contact.branches.*.name' => 'nullable|string|max:255',
            'contact.branches.*.phone' => 'nullable|string|max:50',
            'contact.branches.*.email' => 'nullable|string|max:255',
            'contact.branches.*.address' => 'nullable|string|max:500',
            'contact.branches.*.google_map_url' => 'nullable|string|max:2000',
            'seo.title' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string|max:500',
            'social_links.facebook' => 'nullable|url|max:255',
            'social_links.youtube' => 'nullable|url|max:255',
            'social_links.instagram' => 'nullable|url|max:255',
            'social_links.tiktok' => 'nullable|url|max:255',
            'social_links.custom' => 'nullable|array',
            'social_links.custom.*.icon' => 'nullable|string|max:100',
            'social_links.custom.*.title' => 'nullable|string|max:255',
            'social_links.custom.*.url' => 'nullable|string|max:1000',
            // Embed code validation
            'embed_header' => 'nullable|string',
            'embed_footer' => 'nullable|string',
            // Videos validation
            'videos' => 'nullable|array',
            'videos.*.url' => 'nullable|string|max:1000',
            'videos.*.poster' => 'nullable|string|max:1000',
            // Footer validation
            'footer' => 'nullable|array',
            'footer.*' => 'nullable|string|max:1000',
        ];

        if ($request->user()?->isSuperAdmin()) {
            $rules = [
                ...$rules,
                'multilingual.enabled' => ['required', 'boolean'],
                'multilingual.mode' => ['required', Rule::in([
                    MultilingualSettings::MODE_MANUAL,
                    MultilingualSettings::MODE_GTRANSLATE,
                ])],
                'multilingual.gtranslate.source_locale' => ['nullable', 'string'],
                'multilingual.gtranslate.target_locales' => [
                    Rule::requiredIf(fn () => $request->boolean('multilingual.enabled')
                        && $request->input('multilingual.mode') === MultilingualSettings::MODE_GTRANSLATE),
                    'array',
                    'max:120',
                ],
                'multilingual.gtranslate.target_locales.*' => [
                    'string',
                    'distinct',
                ],
                'multilingual.gtranslate.widget_look' => ['required', Rule::in(['float', 'dropdown_with_flags', 'flags_dropdown', 'dropdown', 'flags', 'flags_name', 'flags_code', 'lang_names', 'lang_codes', 'globe', 'popup', 'popup_search', 'uswds'])],
                'multilingual.gtranslate.position' => ['required', Rule::in(['bottom_left', 'bottom_right', 'top_left', 'top_right', 'inline'])],
                'multilingual.gtranslate.detect_browser_language' => ['required', 'boolean'],
                'multilingual.gtranslate.native_language_names' => ['required', 'boolean'],
            ];
        }

        $validated = $request->validate($rules);

        // Update basic and nested JSON columns
        ProjectSetting::updateOrCreate(
            ['setting_key' => 'shop_name'],
            ['setting_value' => $validated['shop_name']]
        );

        ProjectSetting::updateOrCreate(
            ['setting_key' => 'contact'],
            ['setting_value' => $validated['contact'] ?? []]
        );

        ProjectSetting::updateOrCreate(
            ['setting_key' => 'seo'],
            ['setting_value' => $validated['seo'] ?? []]
        );

        ProjectSetting::updateOrCreate(
            ['setting_key' => 'social_links'],
            ['setting_value' => $validated['social_links'] ?? []]
        );

        // Update Embed codes
        ProjectSetting::updateOrCreate(
            ['setting_key' => 'embed_header'],
            ['setting_value' => $validated['embed_header'] ?? '']
        );

        ProjectSetting::updateOrCreate(
            ['setting_key' => 'embed_footer'],
            ['setting_value' => $validated['embed_footer'] ?? '']
        );

        // Upload logo if uploaded
        if ($request->hasFile('logo') || filled($validated['logo_url'] ?? null)) {
            $logoUrl = $request->hasFile('logo')
                ? $this->cloudinaryService->uploadFile($request->file('logo'), 'settings')
                : MediaUrl::toStorable($validated['logo_url']);
            ProjectSetting::updateOrCreate(
                ['setting_key' => 'logo_url'],
                ['setting_value' => $logoUrl]
            );
        }

        // Upload favicon if uploaded
        if ($request->hasFile('favicon') || filled($validated['favicon_url'] ?? null)) {
            $faviconUrl = $request->hasFile('favicon')
                ? $this->cloudinaryService->uploadFile($request->file('favicon'), 'settings')
                : MediaUrl::toStorable($validated['favicon_url']);
            ProjectSetting::updateOrCreate(
                ['setting_key' => 'favicon_url'],
                ['setting_value' => $faviconUrl]
            );
        }

        // Save website video settings
        if ($request->has('videos') && is_array($request->input('videos'))) {
            $locale = app()->getLocale();
            $userId = $request->user()?->id;
            $allowedKeys = [
                'story.intro.video',
                'story.vision.video',
                'story.mission.video',
                'story.values.video',
                'wholesale.testimonials.video',
                'home.featured.video',
            ];

            foreach ($request->input('videos') as $vKey => $vData) {
                if (in_array($vKey, $allowedKeys, true) && is_array($vData)) {
                    $url = trim($vData['url'] ?? '');
                    $poster = trim($vData['poster'] ?? '');

                    $valToStore = json_encode([
                        'url' => $url,
                        'poster' => $poster,
                    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

                    $this->siteContent->updateLocale(
                        $vKey,
                        \App\Models\SiteBlock::TYPE_VIDEO,
                        $locale,
                        $valToStore,
                        $userId
                    );
                }
            }
        }

        if ($request->has('banners') && is_array($request->input('banners'))) {
            $userId = $request->user()?->id;
            $locale = app()->getLocale();
            $allowedKeys = [
                'home.hero.banner', 'home.hero.title', 'home.hero.subtitle',
                'story.hero.banner', 'story.hero.badge', 'story.hero.title', 'story.hero.lead',
                'wholesale.hero.banner', 'wholesale.hero.title', 'wholesale.hero.subtitle',
                'blog.hero.banner', 'blog.hero.title', 'blog.hero.subtitle',
                'catalog.hero.banner', 'catalog.hero.title', 'catalog.hero.subtitle',
                'contact.hero.banner', 'contact.hero.badge', 'contact.hero.title', 'contact.hero.lead',
            ];

            foreach ($request->input('banners') as $bItem) {
                if (! is_array($bItem)) continue;

                if (! empty($bItem['image_key']) && in_array($bItem['image_key'], $allowedKeys, true) && isset($bItem['image_url'])) {
                    $this->siteContent->updateLocale(
                        $bItem['image_key'],
                        \App\Models\SiteBlock::TYPE_IMAGE,
                        $locale,
                        trim($bItem['image_url']),
                        $userId
                    );
                }

                if (! empty($bItem['badge_key']) && in_array($bItem['badge_key'], $allowedKeys, true) && isset($bItem['badge'])) {
                    $this->siteContent->updateLocale(
                        $bItem['badge_key'],
                        \App\Models\SiteBlock::TYPE_TEXT,
                        $locale,
                        trim($bItem['badge']),
                        $userId
                    );
                }

                if (! empty($bItem['title_key']) && in_array($bItem['title_key'], $allowedKeys, true) && isset($bItem['title'])) {
                    $this->siteContent->updateLocale(
                        $bItem['title_key'],
                        \App\Models\SiteBlock::TYPE_TEXT,
                        $locale,
                        trim($bItem['title']),
                        $userId
                    );
                }

                if (! empty($bItem['subtitle_key']) && in_array($bItem['subtitle_key'], $allowedKeys, true) && isset($bItem['subtitle'])) {
                    $this->siteContent->updateLocale(
                        $bItem['subtitle_key'],
                        \App\Models\SiteBlock::TYPE_TEXT,
                        $locale,
                        trim($bItem['subtitle']),
                        $userId
                    );
                }
            }
        }

        // Save footer settings and synchronize with site_blocks & contact info
        if ($request->has('footer') && is_array($request->input('footer'))) {
            $footerInput = $request->input('footer');
            ProjectSetting::updateOrCreate(
                ['setting_key' => 'footer_settings'],
                ['setting_value' => $footerInput]
            );

            if (! empty($footerInput['company_name'])) {
                ProjectSetting::updateOrCreate(
                    ['setting_key' => 'company_name'],
                    ['setting_value' => $footerInput['company_name']]
                );
            }

            $currentContact = ProjectSetting::where('setting_key', 'contact')->value('setting_value');
            $contactArr = is_array($currentContact) ? $currentContact : (is_string($currentContact) ? json_decode($currentContact, true) : []);
            if (! is_array($contactArr)) {
                $contactArr = [];
            }
            if (! empty($footerInput['hotline'])) {
                $contactArr['phone'] = $footerInput['hotline'];
            }
            if (! empty($footerInput['email'])) {
                $contactArr['email'] = $footerInput['email'];
            }
            if (! empty($footerInput['address'])) {
                $contactArr['address'] = $footerInput['address'];
            }
            ProjectSetting::updateOrCreate(
                ['setting_key' => 'contact'],
                ['setting_value' => $contactArr]
            );

            $locale = app()->getLocale();
            $userId = $request->user()?->id;
            $footerBlockMap = [
                'company_name' => 'footer.company_name',
                'tagline' => 'footer.tagline',
                'address' => 'footer.address',
                'hotline' => 'footer.hotline',
                'email' => 'footer.email',
                'website' => 'footer.website',
                'col2_title' => 'footer.col2_title',
                'col3_title' => 'footer.col3_title',
                'col4_title' => 'footer.col4_title',
                'newsletter_desc' => 'footer.newsletter_desc',
                'copyright' => 'footer.copyright',
            ];

            foreach ($footerBlockMap as $fField => $fBlockKey) {
                if (isset($footerInput[$fField])) {
                    $this->siteContent->updateLocale(
                        $fBlockKey,
                        \App\Models\SiteBlock::TYPE_TEXT,
                        $locale,
                        trim($footerInput[$fField]),
                        $userId
                    );
                }
            }
        }

        if ($request->user()?->isSuperAdmin()) {
            $this->multilingual->update($validated['multilingual']);
            $this->languages->forget();
        }

        ActivityLogger::log('updated', null, 'Cập nhật cấu hình website', [
            'updated_keys' => array_values(array_filter([
                'shop_name',
                'contact',
                'seo',
                'social_links',
                'embed_header',
                'embed_footer',
                $request->has('footer') ? 'footer_settings' : null,
                $request->user()?->isSuperAdmin() ? 'multilingual' : null,
                ($request->hasFile('logo') || filled($validated['logo_url'] ?? null)) ? 'logo_url' : null,
                ($request->hasFile('favicon') || filled($validated['favicon_url'] ?? null)) ? 'favicon_url' : null,
            ])),
        ]);

        $redirectLocale = $this->languages->supportsAdmin(app()->getLocale())
            ? app()->getLocale()
            : $this->languages->defaultLocale();
        $redirectUrl = route('admin.settings.index', ['locale' => $redirectLocale]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật cấu hình website thành công.',
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl)
            ->with('success', 'Đã cập nhật cấu hình website thành công.');
    }
}
