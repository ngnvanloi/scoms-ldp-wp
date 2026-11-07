param(
    [Parameter(Mandatory = $true)][string]$SiteName,
    [string]$SitesRoot = (Join-Path $HOME 'Local Sites')
)

$ErrorActionPreference = 'Stop'

$root    = Split-Path -Parent $PSScriptRoot
$source  = Join-Path $root 'plugin\scoms-landing'
$plugins = Join-Path $SitesRoot "$SiteName\app\public\wp-content\plugins"
$link    = Join-Path $plugins 'scoms-landing'

if (-not (Test-Path $plugins)) { throw "Plugins folder not found: $plugins (check the site name in LocalWP)" }
if (Test-Path $link) { throw "Already exists: $link (delete it first if it is an old copy)" }

New-Item -ItemType Junction -Path $link -Target $source | Out-Null
Write-Host "Linked: $link -> $source"
Write-Host 'Now activate "SCOMS Landing" in wp-admin > Plugins.'
