<?php

namespace App\Http\Middleware;

use App\Settings\BrandingSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyBranding
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $branding = app(BrandingSettings::class);
            view()->share('brandingCss', $this->generateCss($branding));
        } catch (\Throwable $e) {
            view()->share('brandingCss', '');
        }

        return $next($request);
    }

    protected function generateCss(BrandingSettings $b): string
    {
        $vars = [
            '--brand-primary' => $b->color_primary,
            '--brand-primary-fg' => $b->color_primary_foreground,
            '--brand-secondary' => $b->color_secondary,
            '--brand-secondary-fg' => $b->color_secondary_foreground,
            '--brand-accent' => $b->color_accent,
            '--brand-accent-fg' => $b->color_accent_foreground,
            '--brand-destructive' => $b->color_destructive,
            '--brand-font-heading' => "'{$b->font_heading}', system-ui, sans-serif",
            '--brand-font-body' => "'{$b->font_body}', system-ui, sans-serif",
        ];

        $css = ':root {';
        foreach ($vars as $k => $v) {
            $css .= "{$k}: {$v};";
        }
        $css .= '}';

        return $css;
    }
}
