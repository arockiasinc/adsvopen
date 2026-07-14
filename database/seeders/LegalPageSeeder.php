<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use Illuminate\Database\Seeder;

class LegalPageSeeder extends Seeder
{
    /**
     * Seeds the four legal pages linked from the footer and from the
     * advertiser registration consent checkbox. Admins can edit the bodies
     * afterwards from /admin (Legal Pages) — re-running this seeder only
     * creates pages that are missing, so edits are never clobbered.
     */
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            LegalPage::firstOrCreate(
                ['slug' => $page['slug']],
                $page,
            );
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function pages(): array
    {
        return [
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'is_footer' => true,
                'status' => true,
                'sort_order' => 1,
                'content' => $this->privacyPolicy(),
            ],
            [
                'slug' => 'cookies-policy',
                'title' => 'Cookies Policy',
                'is_footer' => true,
                'status' => true,
                'sort_order' => 2,
                'content' => $this->cookiesPolicy(),
            ],
            [
                'slug' => 'terms-of-use',
                'title' => 'Terms of Use',
                'is_footer' => true,
                'status' => true,
                'sort_order' => 3,
                'content' => $this->termsOfUse(),
            ],
            [
                'slug' => 'terms-conditions',
                'title' => 'Terms & Conditions',
                'is_footer' => true,
                'status' => true,
                'sort_order' => 4,
                'content' => $this->termsAndConditions(),
            ],
        ];
    }

    protected function termsAndConditions(): string
    {
        return <<<'HTML'
<h2>Terms &amp; Conditions for VOpen Ads</h2>

<h3>1. Introduction</h3>
<p>Welcome to VOpen Ads, the advertising platform of VOpen Market. By accessing or using this website, by registering an advertiser account, or by placing an advertising order, you agree to comply with and be bound by these Terms &amp; Conditions, our Terms of Use, our Privacy Policy and our Cookies Policy. If you do not agree with any part of these terms, please do not use this website.</p>

<h3>2. Acceptance of Terms</h3>
<p>You must be at least 18 years of age to register an advertiser account. If you are registering on behalf of a business or organization, you represent and warrant that you have the authority to bind that organization to these terms, and that the business details you supply are accurate and current.</p>

<h3>3. Advertiser Account and Approval</h3>
<p>Advertiser accounts are subject to review and approval by VOpen Ads. We may approve, decline, suspend or terminate an account at our discretion, including where the information provided cannot be verified. Until your account is approved, access to campaign and payment features remains restricted. You are responsible for keeping your account credentials confidential and for all activity that occurs under your account.</p>

<h3>4. Advertising Content and Campaign Orders</h3>
<p>You are solely responsible for the advertising creative, copy, landing pages, offers and claims that you submit. You represent that your advertising content is truthful, is not misleading, and does not infringe any third-party intellectual property, privacy or publicity right.</p>
<p>We reserve the right to review, reject, remove or request changes to any advertisement, at any time and for any reason, including content that is unlawful, deceptive, discriminatory, obscene, or that we consider unsuitable for our audience. It is your responsibility to select the correct ad type, placement, targeting and campaign dates when placing an order. Once a campaign has begun serving, orders are generally non-cancellable and non-refundable.</p>

<h3>5. Placement, Targeting and Delivery</h3>
<p>Advertising inventory, placements and targeting options (city, region, province or national) are offered subject to availability. We do not guarantee any specific number of impressions, clicks, conversions, sales, position on a page, or return on advertising spend, unless expressly agreed in writing. Reported metrics are provided for information only and our own measurement is final.</p>

<h3>6. Payment Terms</h3>
<p>Advertising rates are those shown on the platform or in the written quotation issued to you at the time of order. You agree to pay all charges through the payment methods made available on the site, and to provide accurate and complete billing information. Rates are exclusive of applicable taxes unless stated otherwise. We may suspend or stop serving a campaign where payment is not received.</p>

<h3>7. Limitation of Liability</h3>
<p>To the fullest extent permitted by law, VOpen Ads shall not be liable for any direct, indirect, incidental, special or consequential damages, or for any loss of profits, revenue, data, goodwill or business opportunity, arising out of or relating to your use of the platform or the delivery or non-delivery of any advertisement.</p>

<h3>8. Changes to Terms</h3>
<p>We may modify these Terms &amp; Conditions at any time without prior notice. The revised terms take effect when published on this page. Your continued use of the platform after publication constitutes acceptance of the revised terms.</p>

<h3>9. Governing Law</h3>
<p>These terms are governed by and construed in accordance with the laws of the Province of Manitoba and the federal laws of Canada applicable therein. You submit to the exclusive jurisdiction of the courts of Manitoba in respect of any dispute arising out of these terms.</p>

<h3>10. Contact Information</h3>
<p>If you have questions about these Terms &amp; Conditions, please reach us through the contact details published on this website.</p>
HTML;
    }

    protected function termsOfUse(): string
    {
        return <<<'HTML'
<h2>Terms of Use</h2>
<p><strong>Please read these Terms of Use carefully. If you do not agree with the terms and conditions of this agreement, you may not use this site.</strong></p>

<h3>Use of This Site</h3>
<p>This site is operated by VOpen Ads, the advertising platform of VOpen Market, and is made available to you for the purpose of learning about, ordering and managing advertising placements. You may not use this site for any unlawful purpose, to interfere with its operation, to gain unauthorized access to any account or system, or to collect information about other users by automated means.</p>

<h3>Sale of Advertising Services</h3>
<p>Advertising placements offered through this site are sold subject to our Terms &amp; Conditions and to availability. All prices, ad types, placements and targeting options are subject to change without notice. We reserve the right to limit quantities, to refuse any order, and to discontinue any advertising product at any time.</p>

<h3>Cancellations and Refunds</h3>
<p>Because advertising inventory is reserved on your behalf, campaigns that have begun serving are generally non-cancellable and non-refundable. Requests to amend a campaign before it begins serving will be considered on a case-by-case basis and may be subject to a change fee or to the rate applicable at the time of the change.</p>

<h3>Canadian Usage</h3>
<p>This site is directed to businesses in Canada. We make no representation that the content of this site is appropriate or available for use outside Canada. Those who choose to access this site from other locations do so on their own initiative and are responsible for compliance with local law.</p>

<h3>Copyright and Trademarks</h3>
<p>All content on this site — including text, graphics, logos, layouts, icons, images, and software — is the property of VOpen Market or its content suppliers and is protected by Canadian and international copyright and trademark law. You may not reproduce, duplicate, copy, sell, resell or otherwise exploit any portion of this site without our express written permission.</p>

<h3>Passwords and Accounts</h3>
<p>You are responsible for maintaining the confidentiality of your account and password, for restricting access to your device, and for all activity that occurs under your account. Notify us immediately of any unauthorized use of your account.</p>

<h3>Site Security</h3>
<p>You may not violate or attempt to violate the security of this site, including by accessing data not intended for you, probing or scanning the vulnerability of a system or network, attempting to breach security or authentication measures, or interfering with service to any user, host or network. Violations may be investigated and referred to law enforcement.</p>

<h3>Links</h3>
<p>This site may contain links to third-party websites. Those sites are not under our control and we are not responsible for their content, availability, or privacy practices. The inclusion of a link does not imply endorsement.</p>

<h3>User Submissions</h3>
<p>Any advertising creative, comments, feedback or other material you submit to us may be used by us in connection with the operation and promotion of the platform, without compensation to you and without restriction, provided that we handle personal information in accordance with our Privacy Policy. You are responsible for ensuring you hold all rights necessary to grant this permission.</p>

<h3>Objectionable Content</h3>
<p>We reserve the right, but assume no obligation, to remove any content or advertising that we determine, in our sole discretion, to be unlawful, offensive, threatening, defamatory, deceptive, or otherwise objectionable.</p>

<h3>Informational Purposes Only</h3>
<p>Content on this site, including rate cards, audience figures and performance illustrations, is provided for general information only. It does not constitute a guarantee of results, nor does it constitute legal, financial or professional advice.</p>

<h3>Limitation of Liability</h3>
<p>This site and all content are provided on an "as is" and "as available" basis without warranties of any kind, whether express or implied. To the fullest extent permitted by law, VOpen Ads disclaims all liability for any damages arising out of your use of, or inability to use, this site.</p>

<h3>General</h3>
<p>If any provision of these Terms of Use is found to be unlawful or unenforceable, that provision will be severed and the remaining provisions will continue in full force. Our failure to enforce any provision does not constitute a waiver of that provision.</p>
HTML;
    }

    protected function privacyPolicy(): string
    {
        return <<<'HTML'
<h2>Privacy Policy</h2>
<p>VOpen Ads, the advertising platform of VOpen Market, respects your privacy. This policy explains what information we collect from advertisers and visitors, how we use it, and with whom we share it.</p>

<h3>How does VOpen Ads collect information?</h3>
<p>We collect information in three ways: directly from you, automatically as you use the site, and from third-party sources.</p>

<h3>Information We Collect From Interactions With You</h3>
<p>When you register an advertiser account, complete the Start Advertising questionnaire, request a quote, place a campaign order, or contact us, we collect the information you provide. This typically includes your name, business name, industry, company size, business province, website, contact name and title, email address, telephone number, billing details, and the content of your advertising creative and campaign preferences.</p>

<h3>Information We Collect Automatically</h3>
<p>When you visit the site we may automatically collect your IP address, browser type and version, operating system, device identifiers, referring page, the pages you view, and the dates and times of your visits. We collect this using cookies and similar technologies — see our Cookies Policy for detail and for your choices.</p>

<h3>Information From Third-Party Sources</h3>
<p>We may receive information about your business from payment processors, fraud-prevention providers, credit reference agencies, and publicly available business registries, and may combine it with the information we already hold about you.</p>

<h3>How We Use Information</h3>
<p>We use the information we collect to: create and verify your advertiser account; assess and approve applications; prepare quotations and price campaigns; deliver, target, measure and report on your advertising; process payments and issue receipts; provide customer support; detect and prevent fraud and abuse; comply with our legal obligations; and, where permitted, send you information about our advertising products.</p>

<h3>How We Share Information</h3>
<p><strong>Service providers.</strong> We share information with vendors who perform services on our behalf — including hosting, email delivery, analytics, payment processing and fraud detection — who are permitted to use it only to perform those services for us.</p>
<p><strong>Family of companies.</strong> We may share information within the VOpen Market group of companies for the purposes described in this policy.</p>
<p><strong>Fraud detection and legal disclosures.</strong> We may disclose information where we believe in good faith that disclosure is necessary to comply with the law or legal process, to enforce our terms, to detect or prevent fraud or security issues, or to protect the rights, property or safety of VOpen Market, our users or the public.</p>
<p><strong>Sale of business.</strong> If all or part of our business is sold, merged or otherwise transferred, information we hold may be transferred as part of that transaction.</p>
<p>We do not sell your personal information.</p>

<h3>Interest-Based Advertising and Analytics</h3>
<p>We and our analytics and advertising partners use cookies and similar technologies to understand how the site is used and to show you relevant advertising on other sites. You can opt out of interest-based advertising from participating companies through the Digital Advertising Alliance of Canada, and you can opt out of Google Analytics using the browser add-on Google provides.</p>

<h3>Payment and Credit Card Information</h3>
<p>Payment card details are collected and processed by our payment provider. We do not store full card numbers on our systems.</p>

<h3>Your Account and Your Choices</h3>
<p>You can review and update the business and contact information held on your advertiser account by signing in to your account at any time. You may unsubscribe from our promotional emails using the link included in each message; we will still send you transactional messages about your account and campaigns. Subject to applicable law, you may request access to, correction of, or deletion of the personal information we hold about you by contacting us.</p>

<h3>Retention and Security</h3>
<p>We retain information for as long as your account is active and thereafter as required for our legitimate business purposes and legal obligations, including tax and accounting requirements. We use reasonable administrative, technical and physical safeguards to protect the information we hold, though no method of transmission or storage is completely secure.</p>

<h3>Changes to This Policy</h3>
<p>We may update this Privacy Policy from time to time. The revised policy takes effect when published on this page.</p>

<h3>Contact Us</h3>
<p>If you have questions about this Privacy Policy or about how we handle your information, please reach us through the contact details published on this website.</p>
HTML;
    }

    protected function cookiesPolicy(): string
    {
        return <<<'HTML'
<h2>Cookies Policy</h2>
<p>This Cookies Policy explains how VOpen Ads, the advertising platform of VOpen Market Inc., uses cookies and similar technologies on this website. It should be read together with our Privacy Policy.</p>

<h3>What is a cookie?</h3>
<p>A cookie is a small text file that a website places on your device when you visit it. Cookies let the site recognize your device, remember your preferences, keep you signed in, and understand how the site is used. We also use similar technologies such as pixels, tags and local storage; for simplicity we refer to all of them as "cookies" in this policy.</p>

<h3>Which cookies do we use?</h3>
<p><strong>Strictly necessary cookies.</strong> These are required for the site to function. They keep your session active, keep you signed in to your advertiser account, remember the contents of an in-progress campaign order, and protect forms against cross-site request forgery. The site cannot operate correctly without them, so they cannot be switched off.</p>
<p><strong>Preference cookies.</strong> These remember choices you have made — for example your province or targeting selections on the Start Advertising questionnaire — so you do not have to re-enter them.</p>
<p><strong>Analytics cookies.</strong> These help us understand how visitors find and use the site, which pages are viewed, and where visitors encounter difficulty, so that we can improve the platform. The information is aggregated.</p>
<p><strong>Advertising cookies.</strong> These are used by us and by our advertising partners to measure the performance of our own marketing and to show you relevant advertising for our advertising products on other websites.</p>

<h3>Third-party cookies</h3>
<p>Some cookies are set by third parties acting on our behalf, such as our analytics and advertising partners and our payment provider. These parties may collect information about your online activities over time and across different websites. Their use of the information is governed by their own privacy policies.</p>

<h3>How can you control cookies?</h3>
<p>Most browsers let you view, delete and block cookies through their settings. You can usually find these controls in the "Settings", "Preferences" or "Privacy" menu of your browser. Please note that if you block strictly necessary cookies, parts of this site — including signing in to your advertiser account and placing a campaign order — will not work.</p>
<p>To opt out of interest-based advertising from participating companies, you can use the tools provided by the Digital Advertising Alliance of Canada. To opt out of Google Analytics across all websites, you can install the browser add-on that Google provides.</p>

<h3>Do Not Track</h3>
<p>Some browsers transmit a "Do Not Track" signal. There is no common industry standard for how such signals should be interpreted, and this site does not currently respond to them.</p>

<h3>Changes to this policy</h3>
<p>We may update this Cookies Policy from time to time to reflect changes in the technologies we use. The revised policy takes effect when published on this page.</p>

<h3>Contact us</h3>
<p>If you have questions about our use of cookies, please reach us through the contact details published on this website.</p>
HTML;
    }
}
