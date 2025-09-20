@extends('layouts.public')

@section('title', $simReport->title . ' - CSAR')

@section('content')
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 40px 0;">
    <!-- En-tête du rapport -->
    <div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; border-radius: 16px; padding: 40px; margin-bottom: 32px;">
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <a href="{{ route('sim.index') }}" style="color: white; text-decoration: none; margin-right: 16px;">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <h1 style="font-size: 2rem; font-weight: 700; margin: 0;">{{ $simReport->title }}</h1>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 4px;">Période</div>
                <div style="font-weight: 600;">{{ $simReport->period }}</div>
            </div>
            <div>
                <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 4px;">Date de publication</div>
                <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($simReport->published_at)->format('d/m/Y') }}</div>
            </div>
            <div>
                <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 4px;">Statut</div>
                <div style="font-weight: 600; color: #10b981;">Publié</div>
            </div>
        </div>
    </div>

    <!-- Résumé -->
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 16px;">Résumé exécutif</h2>
        <p style="color: #374151; line-height: 1.6; font-size: 1.1rem;">{{ $simReport->summary }}</p>
    </div>

    <!-- Contexte et objectifs -->
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 16px;">Contexte et objectifs</h2>
        <p style="color: #374151; line-height: 1.6;">{{ $simReport->context_objectives }}</p>
    </div>

    <!-- Analyse des prix -->
    @if($simReport->price_analysis)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Analyse des prix (FCFA/kg)</h2>
        
        @foreach($simReport->price_analysis as $category => $products)
        <div style="margin-bottom: 32px;">
            <h3 style="color: #374151; font-size: 1.3rem; font-weight: 600; margin-bottom: 16px; text-transform: capitalize;">
                {{ str_replace('_', ' ', $category) }}
            </h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: #f9fafb; border-radius: 8px;">
                    <thead>
                        <tr style="background: #e5e7eb;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Produit</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juin</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juillet</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Variation mensuelle (%)</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Variation annuelle (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product => $data)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; font-weight: 500; color: #374151; text-transform: capitalize;">
                                {{ str_replace('_', ' ', $product) }}
                            </td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juin'], 0) }}</td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juillet'], 0) }}</td>
                            <td style="padding: 12px; text-align: center; font-weight: 600; 
                                color: {{ $data['variation_mensuelle'] > 0 ? '#dc2626' : ($data['variation_mensuelle'] < 0 ? '#059669' : '#374151') }};">
                                {{ $data['variation_mensuelle'] > 0 ? '+' : '' }}{{ number_format($data['variation_mensuelle'], 2) }}%
                            </td>
                            <td style="padding: 12px; text-align: center; font-weight: 600; 
                                color: {{ $data['variation_annuelle'] > 0 ? '#dc2626' : ($data['variation_annuelle'] < 0 ? '#059669' : '#374151') }};">
                                {{ $data['variation_annuelle'] > 0 ? '+' : '' }}{{ number_format($data['variation_annuelle'], 2) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Niveau d'approvisionnement -->
    @if($simReport->supply_level)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Niveau d'approvisionnement (tonnes)</h2>
        
        @foreach($simReport->supply_level as $category => $products)
        <div style="margin-bottom: 32px;">
            <h3 style="color: #374151; font-size: 1.3rem; font-weight: 600; margin-bottom: 16px; text-transform: capitalize;">
                {{ str_replace('_', ' ', $category) }}
            </h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: #f9fafb; border-radius: 8px;">
                    <thead>
                        <tr style="background: #e5e7eb;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Produit</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juin</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juillet</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Variation (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product => $data)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; font-weight: 500; color: #374151; text-transform: capitalize;">
                                {{ str_replace('_', ' ', $product) }}
                            </td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juin'], 1) }}</td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juillet'], 1) }}</td>
                            <td style="padding: 12px; text-align: center; font-weight: 600; 
                                color: {{ $data['variation'] > 0 ? '#059669' : ($data['variation'] < 0 ? '#dc2626' : '#374151') }};">
                                {{ $data['variation'] > 0 ? '+' : '' }}{{ number_format($data['variation'], 0) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Tendances clés -->
    @if($simReport->key_trends)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Tendances clés</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            @foreach($simReport->key_trends as $trend => $description)
            <div style="background: #f0fdf4; border-radius: 12px; padding: 20px; border-left: 4px solid #059669;">
<h4 style="color: #047857; font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; text-transform: capitalize;">
                    {{ str_replace('_', ' ', $trend) }}
                </h4>
                <p style="color: #374151; line-height: 1.5; margin: 0;">{{ $description }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recommandations -->
    @if($simReport->recommendations)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Recommandations</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            @foreach($simReport->recommendations as $recommendation => $description)
            <div style="background: #f0fdf4; border-radius: 12px; padding: 20px; border-left: 4px solid #10b981;">
                <h4 style="color: #065f46; font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; text-transform: capitalize;">
                    {{ str_replace('_', ' ', $recommendation) }}
                </h4>
                <p style="color: #374151; line-height: 1.5; margin: 0;">{{ $description }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Rapports connexes -->
    @if($relatedReports->count() > 0)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Rapports connexes</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            @foreach($relatedReports as $report)
            <div style="background: #f8fafc; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb;">
                <h4 style="color: #047857; font-size: 1.1rem; font-weight: 600; margin-bottom: 8px;">
                    <a href="{{ route('sim.show', $report) }}" style="color: inherit; text-decoration: none;">
                        {{ $report->title }}
                    </a>
                </h4>
                <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 12px;">{{ $report->period }}</p>
                <p style="color: #374151; line-height: 1.4; margin: 0; font-size: 0.95rem;">
                    {{ Str::limit($report->summary, 120) }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection 

@section('title', $simReport->title . ' - CSAR')

@section('content')
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 40px 0;">
    <!-- En-tête du rapport -->
    <div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; border-radius: 16px; padding: 40px; margin-bottom: 32px;">
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <a href="{{ route('sim.index') }}" style="color: white; text-decoration: none; margin-right: 16px;">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <h1 style="font-size: 2rem; font-weight: 700; margin: 0;">{{ $simReport->title }}</h1>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 4px;">Période</div>
                <div style="font-weight: 600;">{{ $simReport->period }}</div>
            </div>
            <div>
                <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 4px;">Date de publication</div>
                <div style="font-weight: 600;">{{ \Carbon\Carbon::parse($simReport->published_at)->format('d/m/Y') }}</div>
            </div>
            <div>
                <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 4px;">Statut</div>
                <div style="font-weight: 600; color: #10b981;">Publié</div>
            </div>
        </div>
    </div>

    <!-- Résumé -->
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 16px;">Résumé exécutif</h2>
        <p style="color: #374151; line-height: 1.6; font-size: 1.1rem;">{{ $simReport->summary }}</p>
    </div>

    <!-- Contexte et objectifs -->
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 16px;">Contexte et objectifs</h2>
        <p style="color: #374151; line-height: 1.6;">{{ $simReport->context_objectives }}</p>
    </div>

    <!-- Analyse des prix -->
    @if($simReport->price_analysis)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Analyse des prix (FCFA/kg)</h2>
        
        @foreach($simReport->price_analysis as $category => $products)
        <div style="margin-bottom: 32px;">
            <h3 style="color: #374151; font-size: 1.3rem; font-weight: 600; margin-bottom: 16px; text-transform: capitalize;">
                {{ str_replace('_', ' ', $category) }}
            </h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: #f9fafb; border-radius: 8px;">
                    <thead>
                        <tr style="background: #e5e7eb;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Produit</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juin</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juillet</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Variation mensuelle (%)</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Variation annuelle (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product => $data)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; font-weight: 500; color: #374151; text-transform: capitalize;">
                                {{ str_replace('_', ' ', $product) }}
                            </td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juin'], 0) }}</td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juillet'], 0) }}</td>
                            <td style="padding: 12px; text-align: center; font-weight: 600; 
                                color: {{ $data['variation_mensuelle'] > 0 ? '#dc2626' : ($data['variation_mensuelle'] < 0 ? '#059669' : '#374151') }};">
                                {{ $data['variation_mensuelle'] > 0 ? '+' : '' }}{{ number_format($data['variation_mensuelle'], 2) }}%
                            </td>
                            <td style="padding: 12px; text-align: center; font-weight: 600; 
                                color: {{ $data['variation_annuelle'] > 0 ? '#dc2626' : ($data['variation_annuelle'] < 0 ? '#059669' : '#374151') }};">
                                {{ $data['variation_annuelle'] > 0 ? '+' : '' }}{{ number_format($data['variation_annuelle'], 2) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Niveau d'approvisionnement -->
    @if($simReport->supply_level)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Niveau d'approvisionnement (tonnes)</h2>
        
        @foreach($simReport->supply_level as $category => $products)
        <div style="margin-bottom: 32px;">
            <h3 style="color: #374151; font-size: 1.3rem; font-weight: 600; margin-bottom: 16px; text-transform: capitalize;">
                {{ str_replace('_', ' ', $category) }}
            </h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: #f9fafb; border-radius: 8px;">
                    <thead>
                        <tr style="background: #e5e7eb;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Produit</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juin</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Juillet</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151;">Variation (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product => $data)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px; font-weight: 500; color: #374151; text-transform: capitalize;">
                                {{ str_replace('_', ' ', $product) }}
                            </td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juin'], 1) }}</td>
                            <td style="padding: 12px; text-align: center; color: #374151;">{{ number_format($data['juillet'], 1) }}</td>
                            <td style="padding: 12px; text-align: center; font-weight: 600; 
                                color: {{ $data['variation'] > 0 ? '#059669' : ($data['variation'] < 0 ? '#dc2626' : '#374151') }};">
                                {{ $data['variation'] > 0 ? '+' : '' }}{{ number_format($data['variation'], 0) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Tendances clés -->
    @if($simReport->key_trends)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Tendances clés</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            @foreach($simReport->key_trends as $trend => $description)
            <div style="background: #f0fdf4; border-radius: 12px; padding: 20px; border-left: 4px solid #059669;">
<h4 style="color: #047857; font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; text-transform: capitalize;">
                    {{ str_replace('_', ' ', $trend) }}
                </h4>
                <p style="color: #374151; line-height: 1.5; margin: 0;">{{ $description }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recommandations -->
    @if($simReport->recommendations)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px; margin-bottom: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Recommandations</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            @foreach($simReport->recommendations as $recommendation => $description)
            <div style="background: #f0fdf4; border-radius: 12px; padding: 20px; border-left: 4px solid #10b981;">
                <h4 style="color: #065f46; font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; text-transform: capitalize;">
                    {{ str_replace('_', ' ', $recommendation) }}
                </h4>
                <p style="color: #374151; line-height: 1.5; margin: 0;">{{ $description }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Rapports connexes -->
    @if($relatedReports->count() > 0)
    <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #e5e7eb; padding: 32px;">
        <h2 style="color: #059669; font-size: 1.5rem; font-weight: 700; margin-bottom: 24px;">Rapports connexes</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            @foreach($relatedReports as $report)
            <div style="background: #f8fafc; border-radius: 12px; padding: 20px; border: 1px solid #e5e7eb;">
                <h4 style="color: #047857; font-size: 1.1rem; font-weight: 600; margin-bottom: 8px;">
                    <a href="{{ route('sim.show', $report) }}" style="color: inherit; text-decoration: none;">
                        {{ $report->title }}
                    </a>
                </h4>
                <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 12px;">{{ $report->period }}</p>
                <p style="color: #374151; line-height: 1.4; margin: 0; font-size: 0.95rem;">
                    {{ Str::limit($report->summary, 120) }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection 
 
 
 
 
 
 