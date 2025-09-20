<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\TechnicalPartner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = TechnicalPartner::where('status', 'active')
            ->orderBy('name')
            ->get();

        // Partners coming from database (normalized to a simple array structure)
        $dbItems = $partners->map(function (TechnicalPartner $p) {
            return [
                'name' => $p->name,
                'organization' => $p->organization,
                'type' => $p->type ?: 'institution',
                'website' => $p->website,
                'logo_url' => $p->logo ? \Storage::url($p->logo) : null,
            ];
        })->values()->all();

        // Curated partners from the annual report (logos expected in public/images/partners)
        $staticItems = [
            // Government / bilateral
            ['name' => 'Ambassade du Japon au Sénégal', 'type' => 'government', 'website' => 'https://www.sn.emb-japan.go.jp/', 'logo_url' => asset('images/partners/japan.png')],
            ['name' => 'JICA – Agence Japonaise de Coopération Internationale', 'type' => 'agency', 'website' => 'https://www.jica.go.jp/english/', 'logo_url' => asset('images/partners/jica.png')],
            ['name' => 'Royaume d’Arabie Saoudite', 'type' => 'government', 'website' => 'https://embassies.mofa.gov.sa/sites/senegal/EN/Pages/default.aspx', 'logo_url' => asset('images/partners/saudi.png')],

            // Multilateral / UN / Regional
            ['name' => 'Programme Alimentaire Mondial (PAM / WFP)', 'type' => 'agency', 'website' => 'https://www.wfp.org/', 'logo_url' => asset('images/partners/wfp.png')],
            ['name' => 'ARAA – Agence Régionale pour l’Agriculture et l’Alimentation (CEDEAO)', 'type' => 'agency', 'website' => 'https://www.araa.org/', 'logo_url' => asset('images/partners/araa.png')],
            ['name' => 'Union Européenne – Délégation au Sénégal', 'type' => 'agency', 'website' => 'https://www.eeas.europa.eu/delegations/senegal_fr', 'logo_url' => asset('images/partners/eu.png')],
            ['name' => 'USAID Sénégal', 'type' => 'agency', 'website' => 'https://www.usaid.gov/senegal', 'logo_url' => asset('images/partners/usaid.png')],

            // Institutions de l’État (Sénégal)
            ['name' => 'ANSD – Agence Nationale de la Statistique et de la Démographie', 'type' => 'institution', 'website' => 'https://www.ansd.sn/', 'logo_url' => asset('images/partners/ansd.png')],
            ['name' => 'ADL – Agence de Développement Local', 'type' => 'institution', 'website' => 'https://adl.sn/', 'logo_url' => asset('images/partners/adl.png')],
            ['name' => 'FSN – Fonds de Solidarité Nationale', 'type' => 'institution', 'website' => 'https://fsn.gouv.sn/', 'logo_url' => asset('images/partners/fsn.png')],
            ['name' => 'CNDN – Conseil National de Développement de la Nutrition', 'type' => 'institution', 'website' => 'https://www.cndn.sn/', 'logo_url' => asset('images/partners/cndn.png')],
            ['name' => 'SE-CNSA – Secrétariat Exécutif du Conseil National de la Sécurité Alimentaire', 'type' => 'institution', 'website' => 'https://www.cnsa.gouv.sn/', 'logo_url' => asset('images/partners/sec-cnsa.png')],
            ['name' => 'FONGIP – Fonds de Garantie des Investissements Prioritaires', 'type' => 'institution', 'website' => 'https://www.fongip.sn/', 'logo_url' => asset('images/partners/fongip.png')],
            ['name' => 'ARCOP – Autorité de Régulation de la Commande Publique', 'type' => 'institution', 'website' => 'https://www.arcop.sn/', 'logo_url' => asset('images/partners/arcop.png')],

            // Privé / RSE
            ['name' => 'EIFFAGE / SECAA', 'type' => 'private', 'website' => 'https://www.eiffage.sn/', 'logo_url' => asset('images/partners/eiffage.png')],
            ['name' => 'SENHYDRO', 'type' => 'private', 'website' => 'https://senhydro.com/', 'logo_url' => asset('images/partners/senhydro.png')],
            ['name' => 'SIMPA', 'type' => 'private', 'website' => '#', 'logo_url' => asset('images/partners/simpa.png')],
        ];

        // Map known slugs to direct websites and types
        $slugMap = [
            'japan' => ['url' => 'https://www.sn.emb-japan.go.jp/', 'type' => 'government', 'name' => 'Ambassade du Japon au Sénégal'],
            'jica' => ['url' => 'https://www.jica.go.jp/english/', 'type' => 'agency', 'name' => 'JICA'],
            'kr' => ['url' => 'https://www.sn.emb-japan.go.jp/itpr_ja/kr.html', 'type' => 'government', 'name' => 'Programme KR - Aide Alimentaire du Japon'],
            'saudi' => ['url' => 'https://embassies.mofa.gov.sa/sites/senegal/EN/Pages/default.aspx', 'type' => 'government', 'name' => 'Royaume d’Arabie Saoudite'],
            'arabie-saoudite' => ['url' => 'https://embassies.mofa.gov.sa/sites/senegal/EN/Pages/default.aspx', 'type' => 'government', 'name' => 'Royaume d’Arabie Saoudite'],
            'wfp' => ['url' => 'https://www.wfp.org/', 'type' => 'agency', 'name' => 'Programme Alimentaire Mondial (PAM)'],
            'pam' => ['url' => 'https://www.wfp.org/', 'type' => 'agency', 'name' => 'Programme Alimentaire Mondial (PAM)'],
            'araa' => ['url' => 'https://www.araa.org/', 'type' => 'agency', 'name' => 'ARAA – CEDEAO'],
            'cedao' => ['url' => 'https://www.araa.org/', 'type' => 'agency', 'name' => 'ARAA – CEDEAO'],
            'eu' => ['url' => 'https://www.eeas.europa.eu/delegations/senegal_fr', 'type' => 'agency', 'name' => 'Union Européenne'],
            'ue' => ['url' => 'https://www.eeas.europa.eu/delegations/senegal_fr', 'type' => 'agency', 'name' => 'Union Européenne'],
            'usaid' => ['url' => 'https://www.usaid.gov/senegal', 'type' => 'agency', 'name' => 'USAID Sénégal'],
            'ansd' => ['url' => 'https://www.ansd.sn/', 'type' => 'institution', 'name' => 'ANSD'],
            'adl' => ['url' => 'https://adl.sn/', 'type' => 'institution', 'name' => 'ADL'],
            'fsn' => ['url' => 'https://fsn.gouv.sn/', 'type' => 'institution', 'name' => 'FSN'],
            'cndn' => ['url' => 'https://www.cndn.sn/', 'type' => 'institution', 'name' => 'CNDN'],
            'sec-cnsa' => ['url' => 'https://www.cnsa.gouv.sn/', 'type' => 'institution', 'name' => 'SE-CNSA'],
            'fongip' => ['url' => 'https://www.fongip.sn/', 'type' => 'institution', 'name' => 'FONGIP'],
            'arcop' => ['url' => 'https://www.arcop.sn/', 'type' => 'institution', 'name' => 'ARCOP'],
            'eiffage' => ['url' => 'https://www.eiffage.sn/', 'type' => 'private', 'name' => 'EIFFAGE / SECAA'],
            'secaa' => ['url' => 'https://www.eiffage.sn/', 'type' => 'private', 'name' => 'EIFFAGE / SECAA'],
            'senhydro' => ['url' => 'https://senhydro.com/', 'type' => 'private', 'name' => 'SENHYDRO'],
            'simpa' => ['url' => '#', 'type' => 'private', 'name' => 'SIMPA'],
            'primature' => ['url' => 'https://primature.sn/', 'type' => 'government', 'name' => 'Primature'],
            'mfs' => ['url' => 'https://femme.gouv.sn/', 'type' => 'government', 'name' => 'Ministère de la Famille et des Solidarités'],
            'presidence' => ['url' => 'https://www.presidence.sn/', 'type' => 'government', 'name' => 'Présidence de la République'],
        ];

        // Read all files from public/images/partners and build clickable items
        $fileItems = [];
        $files = File::exists(public_path('images/partners')) ? File::files(public_path('images/partners')) : [];
        foreach ($files as $file) {
            $basename = $file->getFilename();
            $slug = strtolower(pathinfo($basename, PATHINFO_FILENAME));
            // Exclusions ponctuelles demandées (ne pas afficher ces partenaires)
            if (in_array($slug, ['eiffage', 'secaa'])) {
                continue;
            }
            $map = $slugMap[$slug] ?? null;
            $fileItems[] = [
                'name' => $map['name'] ?? Str::headline(str_replace(['_', '-'], ' ', $slug)),
                'organization' => null,
                'type' => $map['type'] ?? 'agency',
                'website' => $map['url'] ?? '#',
                'logo_url' => asset('images/partners/' . $basename),
            ];
        }

        // N'afficher QUE les logos présents dans public/images/partners
        $allItems = collect($fileItems)
            ->unique(fn ($item) => ($item['logo_url'] ?? '') . '|' . ($item['name'] ?? ''))
            ->values();
        $grouped = $allItems->groupBy('type');

        return view('public.partners', [
            'grouped' => $grouped,
        ]);
    }
}


