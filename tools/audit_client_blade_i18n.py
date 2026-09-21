import os
import re
from pathlib import Path

CLIENT_VIEWS = Path('resources/views/client')
results = []

vn_regex = re.compile(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]', re.IGNORECASE)

for root, _, files in os.walk(CLIENT_VIEWS):
    for f in files:
        if not f.endswith('.blade.php'):
            continue
        filepath = Path(root) / f
        with open(filepath, 'r', encoding='utf-8', errors='ignore') as fp:
            for idx, line in enumerate(fp, 1):
                raw_line = line.strip()
                # Skip comments
                if raw_line.startswith('{{--') or raw_line.startswith('<!--') or raw_line.startswith('//') or raw_line.startswith('*'):
                    continue
                if vn_regex.search(raw_line):
                    # Check if conditioned by locale or is an editable default or translation
                    has_locale = any(k in raw_line for k in [
                        'getLocale', '$locale', 'isVi', '__(\'', 'trans(', '@lang(',
                        'app(\'translator\')', 'LanguageRegistry', 'editable'
                    ])
                    # Also check for admin-only views (dev toolbar, admin-bar)
                    is_admin_tool = 'dev/' in str(filepath) or 'partials/admin-bar' in str(filepath) or 'partials/inline-' in str(filepath) or 'partials/media-picker' in str(filepath)
                    if not has_locale and not is_admin_tool:
                        results.append((str(filepath), idx, raw_line))

print(f"Total potential unlocalized occurrences: {len(results)}")
for path, line_no, content in results:
    print(f"{path}:{line_no} -> {content[:110]}")
