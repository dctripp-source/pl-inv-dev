@extends('layouts.app')

@section('title', __sr('add_business', 'Prijavite Biznis', 'Пријавите Бизнис'))

@section('content')
<!-- Hero Section -->
<div class="bg-primary py-16">
    <div class="container-platform text-center -mt-20 pt-32 fade-in-left">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            {{ __sr('add_your_business', 'Prijavite Svoj Biznis', 'Пријавите Свој Бизнис') }}
        </h1>
        <p class="text-xl text-blue-100">
            {{ __sr('join_community', 'Pridružite se našoj zajednici', 'Придружите се нашој заједници') }}
        </p>
        <p class="text-xl text-blue-100">
            {{ __sr('join_community_note', 'Na platformu se mogu prijaviti samo korisnici Fonda INVRS', 'На платформу се могу пријавити само корисници Фонда ИНВРС') }}
        </p>
    </div>
</div>

<!-- Form Section -->
<div class="container-platform py-16 bg-white">
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('business.store') }}" method="POST" id="business-form" class="space-y-8">
            @csrf
            
            <!-- Business Information -->
            <div class="space-y-6 fade-in-left delay-100">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __sr('business_information', 'Informacije o biznisu', 'Информације о бизнису') }}
                </h2>
                
                <!-- Business Name -->
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('business_name', 'Naziv biznisa', 'Назив бизниса') }} *
                    </label>
                    <input type="text" 
                           id="business_name" 
                           name="business_name" 
                           value="{{ old('business_name') }}" 
                           required 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('business_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categories -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('categories', 'Kategorije', 'Категорије') }} *
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($categories as $category)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" 
                                       name="categories[]" 
                                       value="{{ $category->id }}" 
                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="ml-2 text-sm">{{ $category->icon }} {{ $category->getDisplayName(getCurrentScript()) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('description', 'Opis biznisa', 'Опис бизниса') }}
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Services -->
                <div>
                    <label for="services" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('services', 'Usluge', 'Услуге') }}
                    </label>
                    <textarea id="services" 
                              name="services" 
                              rows="3" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('services') }}</textarea>
                    @error('services')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Owner Information -->
            <div class="space-y-6 fade-in-left delay-200">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __sr('owner_information', 'Informacije o vlasniku', 'Информације о власнику') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="owner_first_name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __sr('first_name', 'Ime', 'Име') }} *
                        </label>
                        <input type="text" 
                               id="owner_first_name" 
                               name="owner_first_name" 
                               value="{{ old('owner_first_name') }}" 
                               required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('owner_first_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Last Name -->
                    <div>
                        <label for="owner_last_name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __sr('last_name', 'Prezime', 'Презиме') }} *
                        </label>
                        <input type="text" 
                               id="owner_last_name" 
                               name="owner_last_name" 
                               value="{{ old('owner_last_name') }}" 
                               required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('owner_last_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-6 fade-in-left delay-300">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __sr('contact_information', 'Kontakt informacije', 'Контакт информације') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __sr('phone', 'Telefon', 'Телефон') }}
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __sr('email', 'Email', 'Емаил') }}
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('website', 'Veb sajt', 'Веб сајт') }}
                    </label>
                    <input type="url" 
                           id="website" 
                           name="website" 
                           value="{{ old('website') }}" 
                           placeholder="https://"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('website')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address Information -->
            <div class="space-y-6 fade-in-left delay-400">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __sr('address_information', 'Adresa', 'Адреса') }}
                </h2>
                
                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('address', 'Adresa', 'Адреса') }}
                    </label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="{{ old('address') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('city', 'Grad', 'Град') }} *
                    </label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           value="{{ old('city') }}" 
                           required 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('city')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Working Hours -->
            <div class="fade-in-left delay-500">
                <label for="working_hours" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __sr('working_hours', 'Radno vreme', 'Радно време') }}
                </label>
                <textarea id="working_hours" 
                          name="working_hours" 
                          rows="3" 
                          placeholder="{{ __sr('working_hours_placeholder', 'Pon-Pet: 08:00-16:00', 'Пон-Пет: 08:00-16:00') }}"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('working_hours') }}</textarea>
                @error('working_hours')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NAPREDNI UPLOAD SLIKA SISTEM -->
            <div class="fade-in-left delay-600" id="image-upload-section">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    {{ __sr('business_images', 'Slike biznisa', 'Слике бизниса') }}
                </h2>

                <!-- Upload Zona -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center transition-colors duration-200 hover:border-blue-400 hover:bg-blue-50" 
                     id="upload-zone">
                    <div class="mb-4">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-lg text-gray-600 mb-2">
                            {{ __sr('drag_drop_images', 'Prevucite slike ovde ili kliknite da izaberete', 'Превуците слике овде или кликните да изаберете') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ __sr('supported_formats', 'Podržani formati: JPG, PNG, WebP • Maksimalno 10MB po slici', 'Подржани формати: JPG, PNG, WebP • Максимално 10МБ по слици') }}
                        </p>
                    </div>
                    
                    <input type="file" 
                           multiple 
                           accept="image/*" 
                           class="hidden" 
                           id="image-input">
                    
                    <button type="button" 
                            class="bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200"
                            onclick="document.getElementById('image-input').click()">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __sr('select_images', 'Izaberite slike', 'Изаберите слике') }}
                    </button>
                    
                    <!-- Loading indicator -->
                    <div id="upload-loading" class="mt-4 hidden">
                        <div class="inline-flex items-center">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500 mr-3"></div>
                            <span class="text-blue-600">{{ __sr('uploading', 'Upload u toku...', 'Уплоад у току...') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Preview uploadovanih slika -->
                <div id="uploaded-images-container" class="mt-6 hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-images mr-2 text-gray-500"></i>
                            {{ __sr('uploaded_images', 'Uploadovane slike', 'Уплоадоване слике') }}
                            <span id="images-count" class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">0</span>
                        </h4>
                        
                        <button type="button" 
                                id="clear-all-images"
                                class="text-red-600 hover:text-red-800 text-sm font-medium">
                            <i class="fas fa-trash mr-1"></i>
                            {{ __sr('delete_all', 'Obriši sve', 'Обриши све') }}
                        </button>
                    </div>
                    
                    <div id="uploaded-images-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Dinamički dodavane slike -->
                    </div>
                    
                    <div class="mt-3 text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __sr('first_image_main', 'Prva slika će biti postavljena kao glavna slika biznisa', 'Прва слика ће бити постављена као главна слика бизниса') }}
                    </div>
                </div>

                <!-- Error container -->
                <div id="image-errors" class="mt-4 hidden">
                    <!-- Dinamički dodavane greške -->
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-6 fade-in-left delay-700">
                <button type="submit" 
                        id="submit-button"
                        class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    <span id="submit-text">
                        <i class="fas fa-paper-plane mr-2"></i>
                        {{ __sr('submit_business', 'Prijavite Biznis', 'Пријавите Бизнис') }}
                    </span>
                    <span id="submit-loading" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        {{ __sr('submitting', 'Šalje se...', 'Шаље се...') }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CSS stilovi -->
<style>
/* Upload zona hover efekti */
#upload-zone.dragover {
    border-color: #3b82f6;
    background-color: #eff6ff;
}

/* Image preview kartice */
.image-preview-card {
    position: relative;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.2s ease;
}

.image-preview-card:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.image-preview-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.image-actions {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.image-preview-card:hover .image-actions {
    opacity: 1;
}

.delete-image-btn {
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.delete-image-btn:hover {
    background: rgba(220, 38, 38, 1);
    transform: scale(1.1);
}

/* Error styling */
.image-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-top: 0.5rem;
}
</style>

@endsection