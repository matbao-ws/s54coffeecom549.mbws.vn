import os
import sys
import ftplib
from pathlib import Path

FTP_HOST = "203.205.31.252"
FTP_USER = "u513776f0"
FTP_PASS = "P_eeon4WmEq5l%9k"
REMOTE_DIR = "/httpdocs"

BASE_DIR = Path(__file__).resolve().parent.parent

def upload_files(file_list):
    print(f"Connecting to FTP {FTP_HOST}...")
    ftp = ftplib.FTP(FTP_HOST, timeout=30)
    ftp.login(FTP_USER, FTP_PASS)
    print("Authenticated successfully.")

    existing_dirs = {REMOTE_DIR}

    def ensure_remote_dir(remote_dir_path):
        if not remote_dir_path or remote_dir_path in existing_dirs:
            return
        parts = remote_dir_path.strip("/").split("/")
        curr = ""
        for p in parts:
            curr += "/" + p
            if curr in existing_dirs:
                continue
            try:
                ftp.cwd(curr)
                existing_dirs.add(curr)
            except Exception:
                try:
                    ftp.mkd(curr)
                    existing_dirs.add(curr)
                except Exception:
                    pass

    for rel_path in file_list:
        local_path = BASE_DIR / rel_path
        if not local_path.exists():
            print(f"Warning: {local_path} not found.")
            continue
        remote_path = f"{REMOTE_DIR}/{rel_path.replace(chr(92), '/')}"
        remote_dir = os.path.dirname(remote_path)
        ensure_remote_dir(remote_dir)
        size = local_path.stat().st_size
        with open(local_path, "rb") as f:
            ftp.storbinary(f"STOR {remote_path}", f)
        print(f"Uploaded: {rel_path} ({size:,} bytes)")

    ftp.quit()
    print("All files synced successfully!")

if __name__ == "__main__":
    if len(sys.argv) > 1:
        files = sys.argv[1:]
    else:
        # Default modified files
        files = [
            "assets/css/custom.css",
            "public/client-assets/css/custom.css",
            "theme/assets/css/custom.css",
            "index.html",
            "theme/index.html",
            "collections-coffee.html",
            "theme/collections-coffee.html",
            "wholesale.html",
            "theme/wholesale.html",
            "product-detail.html",
            "theme/product-detail.html",
            "our-story.html",
            "theme/our-story.html",
            "blogs-news.html",
            "theme/blogs-news.html",
            "blog-detail.html",
            "theme/blog-detail.html",
            "contact.html",
            "cart.html",
            "checkout.html",
            "policy-shipping.html",
            "policy-returns.html",
            "policy-privacy.html",
            "resources/views/client/partials/header.blade.php"
        ]
    upload_files(files)
