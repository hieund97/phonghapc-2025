<?php

namespace App\Services;

use App\Models\Redirection;
use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Cache;

class RedirectorService implements Redirector
{
  public function getRedirectsFor(Request $request): array
  {
    // Get the redirects from the config
    $configRedirects = config('missing-page-redirector.redirects');
    // Merge both values

    $redirections = Cache::rememberForever('redirections', function () {
      return Redirection::all();
    });
    $arrRedirect = [];
    foreach ($redirections as $row) {
      $linkFrom = str_replace(config('app.url'),'',$row->link_from) ;
      $linkTo   = str_replace(config('app.url'),'',$row->link_to);
      $arrRedirect[$linkFrom] = [$linkTo, $row->type];
    }
    return array_merge($arrRedirect, $configRedirects);
  }
}
