@extends('layouts.admin')

@section('title', 'Nouvelle Alerte de Prix - Administration')

@section('content')
<style>
/* Variables CSS pour la page de création d'alertes */
:root {
    --primary-red: #dc2626;
    --primary-red-dark: #991b1b;
    --warning-orange: #f59e0b;
    --warning-orange-dark: #d97706;
    --success-green: #10b981;
    --success-green-dark: #059669;
    --info-blue: #3b82f6;
    --info-blue-dark: #1d4ed8;
    --light-bg: #f8fafc;
    --medium-gray: #e5e7eb;
    --dark-gray: #374151;
    --text-dark: #111827;
    --text-light: #6b7280;
    --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.08);
    --shadow-medium: 0 10px 30px rgba(15, 23, 42, 0.3);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Container principal */
.create-alert-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

/* Header avec dégradé rouge */
.create-header {
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
    color: #fff;
    padding: 3rem 2rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: var(--shadow-medium);
    position: relative;
    overflow: hidden;
}

.create-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="alert-create" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white" opacity="0.1"/><circle cx="5" cy="15" r="1" fill="white" opacity="0.05"/><circle cx="15" cy="5" r="1" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23alert-create)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.create-header > * {
    position: relative;
    z-index: 2;
}

.create-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.create-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

.btn-secondary-cool {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 10px 22px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
}

.btn-secondary-cool:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    color: white;
    text-decoration: none;
}

/* Layout en grid */
.form-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    align-items: start;
}

/* Carte de formulaire */
.form-container {
    background: #fff;
    border-radius: var(--border-radius);
    padding: 3rem;
    box-shadow: var(--shadow-light);
    border: 1px solid rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
}

.form-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
}

/* Sections du formulaire */
.form-section {
    margin-bottom: 2.5rem;
    padding: 2rem;
    background: #f8fafc;
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary-red);
}

.form-section-title {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-section-icon {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

/* Champs de formulaire */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}

.form-control-cool {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: var(--transition);
    background: #fff;
}

.form-control-cool:focus {
    outline: none;
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    background: #fefbfb;
}

.form-control-cool.is-invalid {
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.select-cool {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    background: #fff;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px;
    padding-right: 48px;
    appearance: none;
    transition: var(--transition);
}

.select-cool:focus {
    outline: none;
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.textarea-cool {
    width: 100%;
    padding: 16px;
    border: 2px solid #e5e7eb;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

.textarea-cool:focus {
    outline: none;
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

/* Sidebar cards */
.sidebar-card {
    background: #fff;
    border-radius: var(--border-radius);
    padding: 2rem;
    box-shadow: var(--shadow-light);
    border: 1px solid rgba(15, 23, 42, 0.08);
    margin-bottom: 2rem;
}

.sidebar-card h3 {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.sidebar-icon {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    background: linear-gradient(135deg, var(--info-blue) 0%, var(--info-blue-dark) 100%);
}

/* Preview card */
.price-preview {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: var(--border-radius);
    padding: 2rem;
    text-align: center;
    border: 2px dashed #d1d5db;
    transition: var(--transition);
}

.preview-icon {
    font-size: 3rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}

.preview-content h4 {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.preview-content .badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.85rem;
}

.preview-prices {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.price-item {
    text-align: center;
}

.price-item small {
    color: var(--text-light);
    font-size: 0.8rem;
    display: block;
    margin-bottom: 4px;
}

.price-item .value {
    font-weight: 700;
    font-size: 1.1rem;
}

/* Guide levels */
.level-guide {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.level-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid;
}

.level-item.low {
    border-left-color: #6b7280;
}

.level-item.medium {
    border-left-color: var(--info-blue);
}

.level-item.high {
    border-left-color: var(--warning-orange);
}

.level-item.critical {
    border-left-color: var(--primary-red);
}

.level-badge {
    padding: 4px 12px;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.8rem;
    color: white;
    min-width: 70px;
    text-align: center;
}

.level-badge.low {
    background: #6b7280;
}

.level-badge.medium {
    background: var(--info-blue);
}

.level-badge.high {
    background: var(--warning-orange);
}

.level-badge.critical {
    background: var(--primary-red);
}

/* Region select styling */
.region-select {
    height: 200px;
    overflow-y: auto;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 8px;
}

.region-select:focus-within {
    border-color: var(--primary-red);
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

/* Boutons d'action */
.action-buttons {
    display: flex;
    gap: 16px;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
    margin-top: 2rem;
}

.btn-primary-cool {
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
    border: none;
    color: white;
    padding: 14px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
}

.btn-primary-cool:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 38, 38, 0.6);
    color: white;
}

.btn-secondary-form {
    background: #f3f4f6;
    border: 2px solid #d1d5db;
    color: #6b7280;
    padding: 12px 26px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
}

.btn-secondary-form:hover {
    background: #e5e7eb;
    border-color: #9ca3af;
    color: #374151;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 1200px) {
    .form-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .create-alert-container {
        padding: 1rem;
    }
    
    .create-header {
        padding: 2rem 1.5rem;
    }
    
    .create-header h1 {
        font-size: 2rem;
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .form-container {
        padding: 2rem 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-container, .sidebar-card {
    animation: fadeInUp 0.6s ease-out;
}

.create-header {
    animation: fadeInUp 0.6s ease-out 0.1s both;
}
</style>

<div class="create-alert-container">
    <!-- Header -->
    <div class="create-header">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z" fill="currentColor" opacity="0.8"/>
                <path d="M12 7V13M12 17H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/>
                <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z" stroke="white" stroke-width="1.5"/>
            </svg>
            Nouvelle Alerte de Prix
        </h1>
        <p>Créer une nouvelle alerte pour surveiller les hausses de prix alimentaires</p>
        <div>
            <a href="{{ route('admin.price-alerts.index') }}" class="btn-secondary-cool">
                <i class="fas fa-arrow-left"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <!-- Layout principal -->
    <div class="form-layout">
        <!-- Formulaire principal -->
        <div class="form-container">
                    <form action="{{ route('admin.price-alerts.store') }}" method="POST">
                        @csrf
                
                <!-- Section: Informations de base -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <span class="form-section-icon">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        Informations de Base
                    </h3>
                        
                        <div class="row">
                        <div class="col-lg-6">
                                <div class="form-group">
                                <label for="product_name" class="form-label">Nom du Produit *</label>
                                <input type="text" class="form-control-cool @error('product_name') is-invalid @enderror" 
                                           id="product_name" name="product_name" value="{{ old('product_name') }}" 
                                       placeholder="Ex: Riz, Mil, Maïs, Huile..." required>
                                    @error('product_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        <div class="col-lg-6">
                                <div class="form-group">
                                <label for="alert_level" class="form-label">Niveau d'Alerte *</label>
                                <select class="select-cool @error('alert_level') is-invalid @enderror" 
                                            id="alert_level" name="alert_level" required>
                                        <option value="">Sélectionner un niveau</option>
                                    <option value="low" {{ old('alert_level') == 'low' ? 'selected' : '' }}>🟢 Faible (< 5%)</option>
                                    <option value="medium" {{ old('alert_level') == 'medium' ? 'selected' : '' }}>🔵 Moyen (5-10%)</option>
                                    <option value="high" {{ old('alert_level') == 'high' ? 'selected' : '' }}>🟡 Élevé (10-20%)</option>
                                    <option value="critical" {{ old('alert_level') == 'critical' ? 'selected' : '' }}>🔴 Critique (> 20%)</option>
                                    </select>
                                    @error('alert_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-6">
                                <div class="form-group">
                                <label for="market_name" class="form-label">Nom du Marché</label>
                                <input type="text" class="form-control-cool @error('market_name') is-invalid @enderror" 
                                       id="market_name" name="market_name" value="{{ old('market_name') }}" 
                                       placeholder="Ex: Marché de Sandaga, Marché de Thiaroye...">
                                @error('market_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        <div class="col-lg-6">
                                <div class="form-group">
                                <label for="region" class="form-label">Région</label>
                                <select class="select-cool @error('region') is-invalid @enderror" 
                                        id="region" name="region">
                                    <option value="">Sélectionner une région</option>
                                    <option value="Dakar" {{ old('region') == 'Dakar' ? 'selected' : '' }}>Dakar</option>
                                    <option value="Thiès" {{ old('region') == 'Thiès' ? 'selected' : '' }}>Thiès</option>
                                    <option value="Diourbel" {{ old('region') == 'Diourbel' ? 'selected' : '' }}>Diourbel</option>
                                    <option value="Fatick" {{ old('region') == 'Fatick' ? 'selected' : '' }}>Fatick</option>
                                    <option value="Kaolack" {{ old('region') == 'Kaolack' ? 'selected' : '' }}>Kaolack</option>
                                    <option value="Kolda" {{ old('region') == 'Kolda' ? 'selected' : '' }}>Kolda</option>
                                    <option value="Louga" {{ old('region') == 'Louga' ? 'selected' : '' }}>Louga</option>
                                    <option value="Matam" {{ old('region') == 'Matam' ? 'selected' : '' }}>Matam</option>
                                    <option value="Saint-Louis" {{ old('region') == 'Saint-Louis' ? 'selected' : '' }}>Saint-Louis</option>
                                    <option value="Tambacounda" {{ old('region') == 'Tambacounda' ? 'selected' : '' }}>Tambacounda</option>
                                    <option value="Ziguinchor" {{ old('region') == 'Ziguinchor' ? 'selected' : '' }}>Ziguinchor</option>
                                    <option value="Kédougou" {{ old('region') == 'Kédougou' ? 'selected' : '' }}>Kédougou</option>
                                    <option value="Sédhiou" {{ old('region') == 'Sédhiou' ? 'selected' : '' }}>Sédhiou</option>
                                    <option value="Kaffrine" {{ old('region') == 'Kaffrine' ? 'selected' : '' }}>Kaffrine</option>
                                </select>
                                @error('region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        </div>

                <!-- Section: Prix -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <span class="form-section-icon">
                            <i class="fas fa-calculator"></i>
                        </span>
                        Données de Prix
                    </h3>

    <div class="row">
                        <div class="col-lg-6">
                                <div class="form-group">
                                <label for="previous_price" class="form-label">Prix Précédent (FCFA) *</label>
                                <input type="number" step="0.01" class="form-control-cool @error('previous_price') is-invalid @enderror" 
                                           id="previous_price" name="previous_price" value="{{ old('previous_price') }}" 
                                           placeholder="0.00" required>
                                    @error('previous_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        <div class="col-lg-6">
                                <div class="form-group">
                                <label for="current_price" class="form-label">Prix Actuel (FCFA) *</label>
                                <input type="number" step="0.01" class="form-control-cool @error('current_price') is-invalid @enderror" 
                                           id="current_price" name="current_price" value="{{ old('current_price') }}" 
                                           placeholder="0.00" required>
                                    @error('current_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Section: Détails -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <span class="form-section-icon">
                            <i class="fas fa-edit"></i>
                        </span>
                        Détails de l'Alerte
                    </h3>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                        <textarea class="textarea-cool @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Description détaillée de l'alerte, causes possibles, impacts...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Notes Supplémentaires</label>
                        <textarea class="textarea-cool @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="Notes internes, recommandations, mesures à prendre...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                        <div class="form-group">
                            <label for="affected_regions" class="form-label">Régions Affectées</label>
                        <select class="region-select @error('affected_regions') is-invalid @enderror" 
                                    id="affected_regions" name="affected_regions[]" multiple>
                                <option value="Dakar">Dakar</option>
                                <option value="Thiès">Thiès</option>
                                <option value="Diourbel">Diourbel</option>
                                <option value="Fatick">Fatick</option>
                                <option value="Kaolack">Kaolack</option>
                                <option value="Kolda">Kolda</option>
                                <option value="Louga">Louga</option>
                                <option value="Matam">Matam</option>
                                <option value="Saint-Louis">Saint-Louis</option>
                                <option value="Tambacounda">Tambacounda</option>
                                <option value="Ziguinchor">Ziguinchor</option>
                                <option value="Kédougou">Kédougou</option>
                                <option value="Sédhiou">Sédhiou</option>
                                <option value="Kaffrine">Kaffrine</option>
                            </select>
                            @error('affected_regions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        <small class="text-muted">Maintenez Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs régions</small>
                        </div>
                        </div>

                <!-- Boutons d'action -->
                <div class="action-buttons">
                    <button type="submit" class="btn-primary-cool">
                        <i class="fas fa-save"></i>
                        Créer l'Alerte
                            </button>
                    <a href="{{ route('admin.price-alerts.index') }}" class="btn-secondary-form">
                        <i class="fas fa-times"></i>
                        Annuler
                            </a>
                        </div>
                    </form>
                </div>

        <!-- Sidebar avec aperçu et guide -->
        <div class="sidebar">
            <!-- Aperçu de l'augmentation -->
            <div class="sidebar-card">
                <h3>
                    <span class="sidebar-icon">
                        <i class="fas fa-chart-line"></i>
                    </span>
                    Aperçu de l'Augmentation
                </h3>
                <div id="price-preview" class="price-preview">
                    <div class="preview-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <p style="color: var(--text-light); margin: 0;">Remplissez les prix pour voir l'aperçu</p>
            </div>
        </div>

            <!-- Guide des niveaux -->
            <div class="sidebar-card">
                <h3>
                    <span class="sidebar-icon">
                        <i class="fas fa-info-circle"></i>
                    </span>
                    Guide des Niveaux
                </h3>
                <div class="level-guide">
                    <div class="level-item low">
                        <span class="level-badge low">Faible</span>
                        <div>
                            <div style="font-weight: 600; color: var(--text-dark);">Augmentation < 5%</div>
                            <small style="color: var(--text-light);">Variation normale du marché</small>
                        </div>
                    </div>
                    <div class="level-item medium">
                        <span class="level-badge medium">Moyen</span>
                        <div>
                            <div style="font-weight: 600; color: var(--text-dark);">Augmentation 5-10%</div>
                            <small style="color: var(--text-light);">Surveillance recommandée</small>
                </div>
            </div>
                    <div class="level-item high">
                        <span class="level-badge high">Élevé</span>
                        <div>
                            <div style="font-weight: 600; color: var(--text-dark);">Augmentation 10-20%</div>
                            <small style="color: var(--text-light);">Action requise</small>
                </div>
                    </div>
                    <div class="level-item critical">
                        <span class="level-badge critical">Critique</span>
                        <div>
                            <div style="font-weight: 600; color: var(--text-dark);">Augmentation > 20%</div>
                            <small style="color: var(--text-light);">Intervention immédiate</small>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Calcul automatique de l'augmentation
    function calculateIncrease() {
        const previousPrice = parseFloat($('#previous_price').val()) || 0;
        const currentPrice = parseFloat($('#current_price').val()) || 0;
        
        if (previousPrice > 0 && currentPrice > 0) {
            const increase = ((currentPrice - previousPrice) / previousPrice) * 100;
            const increaseFormatted = increase.toFixed(1);
            
            let level = 'secondary';
            let levelText = 'Faible';
            let levelColor = 'var(--text-light)';
            
            if (increase >= 20) {
                level = 'critical';
                levelText = 'Critique';
                levelColor = 'var(--primary-red)';
            } else if (increase >= 10) {
                level = 'high';
                levelText = 'Élevé';
                levelColor = 'var(--warning-orange)';
            } else if (increase >= 5) {
                level = 'medium';
                levelText = 'Moyen';
                levelColor = 'var(--info-blue)';
            } else {
                level = 'low';
                levelText = 'Faible';
                levelColor = '#6b7280';
            }
            
            $('#price-preview').html(`
                <div class="preview-content">
                    <h4 style="color: ${levelColor};">+${increaseFormatted}%</h4>
                    <span class="badge level-badge ${level}">${levelText}</span>
                    <div class="preview-prices">
                        <div class="price-item">
                            <small>Prix précédent</small>
                            <div class="value">${previousPrice.toLocaleString()} FCFA</div>
                        </div>
                        <div class="price-item">
                            <small>Prix actuel</small>
                            <div class="value" style="color: var(--success-green);">${currentPrice.toLocaleString()} FCFA</div>
                        </div>
                    </div>
                </div>
            `);
            
            // Mise à jour automatique du niveau d'alerte
            $('#alert_level').val(level);
            
            // Animation du preview
            $('#price-preview').css('transform', 'scale(1.02)');
            setTimeout(() => {
                $('#price-preview').css('transform', 'scale(1)');
            }, 200);
        } else {
            $('#price-preview').html(`
                <div class="preview-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <p style="color: var(--text-light); margin: 0;">Remplissez les prix pour voir l'aperçu</p>
            `);
        }
    }
    
    // Événements pour le calcul automatique
    $('#previous_price, #current_price').on('input', calculateIncrease);
    
    // Validation en temps réel
    $('input[required], select[required]').on('blur', function() {
        if (!$(this).val()) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Auto-resize des textareas
    $('textarea').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Validation du formulaire
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Vérifier les champs requis
        $(this).find('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires (*)');
            return false;
        }
    });
    
    // Amélioration de la sélection multiple des régions
    $('#affected_regions').on('change', function() {
        const selectedCount = $(this).val() ? $(this).val().length : 0;
        const label = $('label[for="affected_regions"]');
        
        if (selectedCount > 0) {
            label.html(`Régions Affectées <span style="color: var(--success-green); font-weight: 700;">(${selectedCount} sélectionnée${selectedCount > 1 ? 's' : ''})</span>`);
        } else {
            label.html('Régions Affectées');
        }
    });
});
</script>
@endpush 
@endsection
 