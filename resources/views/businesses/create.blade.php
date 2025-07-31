@extends('layouts.app')

@section('title', __sr('add_business', 'Prijavite Biznis', 'Пријавите Бизнис'))

@section('content')
<!-- Hero Section -->
<div class="bg-primary py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center -mt-20 pt-32">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            {{ __sr('add_your_business', 'Prijavite Svoj Biznis', 'Пријавите Свој Бизнис') }}
        </h1>
        <p class="text-xl text-blue-100">
            {{ __sr('join_community', 'Pridružite se našoj zajednici', 'Придружите се нашој заједници') }}
        </p>
		<p class="text-xl text-blue-100">
            {{ __sr('join_community', 'Na platformu se mogu prijaviti samo korisnici Fonda INVRS', 'На платформу се могу пријавити само корисници Фонда ИНВРС') }}
        </p>
    </div>
</div>

<!-- Form Section -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-white">
    <form action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Business Information -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __sr('business_information', 'Informacije o biznisu', 'Информације о бизнису') }}
            </h2>
            
            <!-- Business Name - SAMO JEDNO POLJE -->
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

            <!-- Description - SAMO JEDNO POLJE -->
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

            <!-- Services - SAMO JEDNO POLJE -->
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

        <!-- Owner Information - SAMO OSNOVNA POLJA -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __sr('owner_information', 'Informacije o vlasniku', 'Информације о власнику') }}
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name - SAMO JEDNO POLJE -->
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
                
                <!-- Last Name - SAMO JEDNO POLJE -->
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
        <div class="space-y-6">
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
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __sr('address_information', 'Adresa', 'Адреса') }}
            </h2>
            
            <!-- Address - SAMO JEDNO POLJE -->
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
            
            <!-- City - SAMO JEDNO POLJE -->
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
        <div>
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

        <!-- Images -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ __sr('business_images', 'Slike biznisa', 'Слике бизниса') }}
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 mb-2">
                    {{ __sr('upload_images', 'Kliknite da otpremite slike ili ih prevucite ovde', 'Кликните да отпремите слике или их превуците овде') }}
                </p>
                <input type="file" 
                       name="images[]" 
                       multiple 
                       accept="image/*" 
                       class="hidden" 
                       id="business-images"
                       onchange="handleImageSelection(this)">
                <label for="business-images" class="bg-primary text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-blue-700 transition-colors">
                    {{ __sr('choose_files', 'Izaberite fajlove', 'Изаберите фајлове') }}
                </label>
                <p class="text-xs text-gray-500 mt-2">
                    {{ __sr('image_requirements', 'Maksimalno 5 slika, do 10MB po slici (automatski će biti optimizovane)', 'Максимално 5 слика, до 10МБ по слици (аутоматски ће бити оптимизоване)') }}
                </p>
            </div>
            
            <!-- Selected Images Preview -->
            <div id="image-preview-container" class="mt-4 hidden">
                <h4 class="text-sm font-medium text-gray-700 mb-3">{{ __sr('selected_images', 'Izabrane slike', 'Изабране слике') }}:</h4>
                <div id="image-preview-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"></div>
            </div>
            
            @error('images')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-center pt-6">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                <i class="fas fa-paper-plane mr-2"></i>
                {{ __sr('submit_business', 'Prijavite Biznis', 'Пријавите Бизнис') }}
            </button>
        </div>
    </form>
</div>

<!-- JavaScript za image preview -->
<script>
function handleImageSelection(input) {
    const container = document.getElementById('image-preview-container');
    const grid = document.getElementById('image-preview-grid');
    
    // Clear previous previews
    grid.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        container.classList.remove('hidden');
        
        // Show selected files
        Array.from(input.files).forEach((file, index) => {
            if (index < 5) { // Limit to 5 images
                const previewDiv = document.createElement('div');
                previewDiv.className = 'relative group';
                
                const img = document.createElement('img');
                img.className = 'w-full h-24 object-cover rounded-lg border border-gray-200';
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
                
                const filename = document.createElement('p');
                filename.className = 'text-xs text-gray-600 mt-1 truncate';
                filename.textContent = file.name;
                
                const filesize = document.createElement('p');
                filesize.className = 'text-xs text-gray-500';
                filesize.textContent = formatFileSize(file.size);
                
                previewDiv.appendChild(img);
                previewDiv.appendChild(filename);
                previewDiv.appendChild(filesize);
                
                grid.appendChild(previewDiv);
            }
        });
        
        // Show warning if more than 5 files selected
        if (input.files.length > 5) {
            const warning = document.createElement('div');
            warning.className = 'col-span-full bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mt-2';
            warning.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>{{ __sr("max_5_images", "Možete odabrati maksimalno 5 slika. Prve 5 će biti korišćene.", "Можете одабрати максимално 5 слика. Првих 5 ће бити коришћене.") }}';
            grid.appendChild(warning);
        }
    } else {
        container.classList.add('hidden');
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Drag and drop functionality
const dropArea = document.querySelector('.border-dashed');
const fileInput = document.getElementById('business-images');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropArea.classList.add('border-primary', 'bg-blue-50');
}

function unhighlight(e) {
    dropArea.classList.remove('border-primary', 'bg-blue-50');
}

dropArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    fileInput.files = files;
    handleImageSelection(fileInput);
}
</script>
@endsection