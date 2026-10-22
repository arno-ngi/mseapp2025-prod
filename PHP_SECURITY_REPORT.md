# PHP Version & Security Vulnerability Report

## Executive Summary

* **Installed PHP Version:** `PHP 8.3.6 (cli)`
* **Build Date:** Jan 7, 2026
* **Branch:** PHP 8.3
* **Branch Release Date:** Nov 23, 2023
* **Active Support End Date:** Dec 31, 2025
* **Security Support End Date:** **Dec 31, 2027**

### Lifecycle Status Summary
While the **PHP 8.3 release branch itself is officially in its security support window** until December 31, 2027, the installed point release (**8.3.6**) is **outdated and contains critical security vulnerabilities**. Many point releases have been issued since 8.3.6 (up through PHP 8.3.36) to patch significant security issues, including Remote Code Execution (RCE), Command Injection, SQL Injection, Buffer Overflows, and Cross-Site Scripting (XSS).

---

## Detailed Known Security Vulnerabilities (CVEs) Affecting PHP 8.3.6

The installed PHP 8.3.6 version lacks security fixes resolved in point releases **8.3.7 through 8.3.36**:

### 1. CLI & CGI Execution / Remote Code Execution (RCE)
* **CVE-2024-4577:** Argument injection vulnerability in CGI mode allowing Remote Code Execution (RCE) on Windows environments.
* **CVE-2024-1874:** Command injection via array-ish `$command` parameter in `proc_open()`.
* **CVE-2024-5585:** Bypass of `proc_open()` command injection fix on Windows.
* **CVE-2024-8926 / CVE-2024-8927:** CGI parameter injection and `cgi.force_redirect` configuration bypass.
* **GHSA-4w77-75f9-2c8w:** Heap use-after-free in `sapi_read_post_data` processing in CLI SAPI interface.

### 2. Core Engine & Memory Corruption
* **GHSA-w8hw-w9fx-j79w / GHSA-6wmf-4rv5-p3rp:** Bailout state corruption leading to memory corruption.
* **CVE-2024-11235:** Use-after-free via reference counting in `php_request_shutdown()`.

### 3. HTTP Client, Streams & Network Protocols
* **CVE-2024-11234:** Proxy configuration in stream context allowing CRLF injection in URIs.
* **CVE-2024-11233:** Single-byte overread in `convert.quoted-printable-decode` stream filter.
* **CVE-2025-1217:** Header parser of `http` stream wrapper failing to handle folded headers.
* **CVE-2025-1734:** Stream HTTP wrapper missing colon check in headers.
* **CVE-2025-1736:** Stream HTTP wrapper basic auth header omission during redirects.
* **CVE-2025-1861:** Stream HTTP wrapper truncating redirect location headers.
* **CVE-2026-12184:** Segfault / memory corruption in `file_get_contents()` with HTTPS proxy.
* **CVE-2026-91766:** Cross-origin credential leak in HTTP stream wrapper redirects.
* **CVE-2026-92842:** Out-of-bounds read in `convert.*` stream filters with NUL in line break characters.
* **CVE-2026-93682:** Out-of-bounds read in HTTP stream wrapper following redirects with empty Location header.

### 4. OpenSSL Extension
* **CVE-2026-14355:** Memory corruption (`zend_mm_heap` corrupted) in `openssl_encrypt()` with AES-WRAP-PAD.
* **CVE-2026-91767:** Heap buffer overflow in `php_openssl_matches_wildcard_name()` on crafted server cert wildcard CN.
* **CVE-2026-91769:** TLS hostname verification falling back to Subject CN after SAN mismatch.

### 5. Database Drivers & Extensions
* **CVE-2024-8929 / CVE-2025-1218:** Heap buffer over-read & packet over-reads in `mysqlnd` wire protocol.
* **CVE-2024-8932:** Out-of-bounds access in `ldap_escape()`.
* **CVE-2024-11236:** Integer overflow in DBLib and Firebird quoters causing OOB writes.
* **CVE-2025-14179:** SQL injection via NUL bytes in quoted strings in `PDO_Firebird`.
* **CVE-2025-14180:** Null dereference in PDO quoting result.
* **CVE-2026-17543:** SQL injection via `E'...'` backslash breakout in `PGSQL`.

### 6. Archive & File Formats
* **CVE-2023-3824:** Buffer mismanagement in `phar_dir_read()`.
* **CVE-2026-6103:** Integer overflow in `phar_tar_number()` allowing TAR archive entry injection.
* **CVE-2026-7260:** Crash via recursive symlinks in `Phar`.
* **CVE-2026-9672:** Libgd vulnerability causing heap buffer overflows in GD image processing.

### 7. Web Services & Protocols (SOAP & FPM)
* **CVE-2025-6491 / CVE-2025-14181:** NULL pointer dereference & integer overflow to buffer overflow in SOAP extension.
* **CVE-2026-6722 / CVE-2026-7261 / CVE-2026-7262:** Memory corruption & use-after-free vulnerabilities in SOAP.
* **CVE-2026-91765:** Unbounded recursion in SOAP server-side XML cleanup.
* **CVE-2024-9026 / CVE-2026-6735:** Log corruption and status endpoint XSS in PHP-FPM.
* **CVE-2026-91768:** IPv6 ACL bypass in FastCGI `listen.allowed_clients` due to partial address comparison.

### 8. Standard Library & Data Parsing
* **CVE-2024-2756:** Cookie prefix (`__Host-`/`__Secure-`) bypass due to improper parsing.
* **CVE-2024-2757:** Infinite loop / denial of service in `mb_encode_mimeheader()`.
* **CVE-2024-3096:** Incorrect return value in `password_verify()` under specific hash inputs.
* **CVE-2024-5458:** Filter bypass in `filter_var()` with `FILTER_VALIDATE_URL`.
* **CVE-2025-1220:** Null byte termination in hostnames (`dns_get_record()`).
* **CVE-2025-14177:** Memory information leak in `getimagesize()`.
* **CVE-2025-14178:** Heap buffer overflow in `array_merge()`.
* **CVE-2026-7258 / CVE-2026-7259:** Out-of-bounds access and null pointer dereference in `mbstring`.
* **CVE-2026-7568:** Signed integer overflow in character array offset in `Standard`.

---

## Remediation & Recommendations

1. **Upgrade PHP Patch Version Immediately:** Upgrade to the latest PHP 8.3 patch release (**PHP 8.3.36 or higher**), or upgrade to **PHP 8.4** / **PHP 8.5**.
2. **System Dependencies:** Ensure system libraries (`OpenSSL`, `libxml2`, `libgd`, `libpq`) are updated regularly alongside PHP binaries.
