import os
import sys
from pathlib import Path

# Add tools to sys.path
BASE_DIR = Path(__file__).resolve().parent.parent
sys.path.append(str(BASE_DIR / "tools"))

from deploy_files import upload_files
from remote_probe import run_remote_php

files_to_deploy = [
    # Blade template
    "resources/views/client/pages/home.blade.php",
    
    # Public client assets
    "public/client-assets/images/s54/hero_banner_s54.png",
    "public/client-assets/images/s54/s54_story_blend_intro.png",
    "public/client-assets/images/s54/roasting_facility.png",
    
    # Public client assets - products
    "public/client-assets/images/s54/products/combo_12goi.jpg",
    "public/client-assets/images/s54/products/combo_12goi.png",
    "public/client-assets/images/s54/products/combo_12goi_dung_thu.jpg",
    "public/client-assets/images/s54/products/combo_12goi_dung_thu.png",
    "public/client-assets/images/s54/products/may_xay_vbz01_5.jpg",
    "public/client-assets/images/s54/products/may_xay_vbz01_5.png",
    "public/client-assets/images/s54/products/robusta_250g.jpg",
    "public/client-assets/images/s54/products/robusta_250g.png",
    "public/client-assets/images/s54/products/robusta_500g.jpg",
    "public/client-assets/images/s54/products/robusta_500g.png",
    "public/client-assets/images/s54/products/tui_3in1_456g.jpg",
    "public/client-assets/images/s54/products/tui_3in1_456g.png",

    # Public client assets - news
    "public/client-assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.webp",
    "public/client-assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.png",
    "public/client-assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.webp",
    "public/client-assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.png",
    "public/client-assets/images/s54/news/news_11_s54_coffee_la_ai.webp",
    "public/client-assets/images/s54/news/news_11_s54_coffee_la_ai.png",
    "public/client-assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.webp",
    "public/client-assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.png",

    # assets root
    "assets/images/s54/hero_banner_s54.png",
    "assets/images/s54/s54_story_blend_intro.png",
    "assets/images/s54/roasting_facility.png",
    "assets/images/s54/products/combo_12goi.jpg",
    "assets/images/s54/products/combo_12goi.png",
    "assets/images/s54/products/combo_12goi_dung_thu.jpg",
    "assets/images/s54/products/combo_12goi_dung_thu.png",
    "assets/images/s54/products/may_xay_vbz01_5.jpg",
    "assets/images/s54/products/may_xay_vbz01_5.png",
    "assets/images/s54/products/robusta_250g.jpg",
    "assets/images/s54/products/robusta_250g.png",
    "assets/images/s54/products/robusta_500g.jpg",
    "assets/images/s54/products/robusta_500g.png",
    "assets/images/s54/products/tui_3in1_456g.jpg",
    "assets/images/s54/products/tui_3in1_456g.png",
    "assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.webp",
    "assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.png",
    "assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.webp",
    "assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.png",
    "assets/images/s54/news/news_11_s54_coffee_la_ai.webp",
    "assets/images/s54/news/news_11_s54_coffee_la_ai.png",
    "assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.webp",
    "assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.png",

    # theme/assets root
    "theme/assets/images/s54/hero_banner_s54.png",
    "theme/assets/images/s54/s54_story_blend_intro.png",
    "theme/assets/images/s54/roasting_facility.png",
    "theme/assets/images/s54/products/combo_12goi.jpg",
    "theme/assets/images/s54/products/combo_12goi.png",
    "theme/assets/images/s54/products/combo_12goi_dung_thu.jpg",
    "theme/assets/images/s54/products/combo_12goi_dung_thu.png",
    "theme/assets/images/s54/products/may_xay_vbz01_5.jpg",
    "theme/assets/images/s54/products/may_xay_vbz01_5.png",
    "theme/assets/images/s54/products/robusta_250g.jpg",
    "theme/assets/images/s54/products/robusta_250g.png",
    "theme/assets/images/s54/products/robusta_500g.jpg",
    "theme/assets/images/s54/products/robusta_500g.png",
    "theme/assets/images/s54/products/tui_3in1_456g.jpg",
    "theme/assets/images/s54/products/tui_3in1_456g.png",
    "theme/assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.webp",
    "theme/assets/images/s54/news/news_1_vi_sao_viet_nam_la_cuong_quoc_ca_phe.png",
    "theme/assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.webp",
    "theme/assets/images/s54/news/news_2_ieu_gi_lam_nen_su_khac_biet_cua_ca_phe_v.png",
    "theme/assets/images/s54/news/news_11_s54_coffee_la_ai.webp",
    "theme/assets/images/s54/news/news_11_s54_coffee_la_ai.png",
    "theme/assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.webp",
    "theme/assets/images/s54/news/news_12_y_nghia_cua_ten_goi_s54_la_gi.png",
]

print(f"Deploying {len(files_to_deploy)} files to MatBao server...")
upload_files(files_to_deploy)

print("\nClearing Laravel compiled view cache on server...")
clear_views_code = """
$viewsPath = __DIR__ . '/storage/framework/views';
if (is_dir($viewsPath)) {
    $files = glob($viewsPath . '/*');
    $count = 0;
    foreach ($files as $file) {
        if (is_file($file)) {
            @unlink($file);
            $count++;
        }
    }
    echo "Cleared $count compiled view cache files.\\n";
} else {
    echo "Views directory not found: $viewsPath\\n";
}
"""
res = run_remote_php(clear_views_code)
print(f"Remote output: {res}")
