$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $PSScriptRoot
$slug = 'scoms-landing'
$main = Join-Path $root "plugin\$slug\$slug.php"

$match = Select-String -Path $main -Pattern '^\s*\*\s*Version:\s*(\S+)' | Select-Object -First 1
if (-not $match) { throw "Version header not found in $main" }
$version = $match.Matches[0].Groups[1].Value

if (Get-Command php -ErrorAction SilentlyContinue) {
    Get-ChildItem -Path (Join-Path $root "plugin\$slug") -Recurse -Filter *.php | ForEach-Object {
        & php -l $_.FullName | Out-Null
        if ($LASTEXITCODE -ne 0) { throw "PHP syntax error in $($_.FullName)" }
    }
    Write-Host 'PHP syntax check: OK'
}

$dist = Join-Path $root 'dist'
New-Item -ItemType Directory -Force -Path $dist | Out-Null
$zip = Join-Path $dist "$slug-$version.zip"
if (Test-Path $zip) { Remove-Item $zip -Force }

& "$env:SystemRoot\System32\tar.exe" -a -cf $zip -C (Join-Path $root 'plugin') $slug
if ($LASTEXITCODE -ne 0) { throw 'tar failed' }

Write-Host "Built: $zip"
