<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

class CSPPolicy extends Policy
{
    public function configure()
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, [Keyword::SELF, 'www.google-analytics.com'])
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::IMG, [Keyword::SELF, 'data:', 'www.youtube.com', 'i.ytimg.com', 'stella.com', 'www.stella.com', 'localhost', 'www.facebook.com', 'www.google-analytics.com'])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::SCRIPT, [Keyword::SELF, Keyword::UNSAFE_INLINE, 'www.youtube.com', 'http://www.youtube.com/', 'connect.facebook.net', 'platform.twitter.com', 'www.googletagmanager.com', 'www.google-analytics.com'])
            ->addDirective(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE, 'fonts.googleapis.com'])
            ->addDirective(Directive::FONT, [Keyword::SELF, 'fonts.gstatic.com', 'data:'])
            ->addDirective(Directive::FRAME, [Keyword::SELF, 'www.youtube.com', 'platform.twitter.com/']);
//            ->addNonceForDirective(Directive::SCRIPT)
//            ->addNonceForDirective(Directive::STYLE);
    }
}
