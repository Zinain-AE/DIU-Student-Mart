@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-[2.5rem] shadow-2xl border border-slate-50">
        <h2 class="text-3xl font-black text-blue-900 mb-2 text-center">Post Your <span class="text-orange-600">Product</span></h2>
        <p class="text-center text-slate-400 font-medium mb-8">Sell your used books, gadgets or equipment to fellow students</p>
        
        {{-- Validation Errors Display --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl">
                <ul class="list-disc list-inside text-sm text-red-600 font-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            {{-- Product Name --}}
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Product Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full bg-slate-50 border-2 border-transparent rounded-2xl p-4 focus:bg-white focus:border-blue-500 outline-none transition-all font-bold text-blue-900 shadow-inner" 
                    placeholder="Ex: Calculus 10th Edition Book" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Price --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Price (BDT)</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                        class="w-full bg-slate-50 border-2 border-transparent rounded-2xl p-4 focus:bg-white focus:border-blue-500 outline-none transition-all font-bold text-blue-900 shadow-inner" 
                        placeholder="500" required>
                </div>

                {{-- NEW: Stock/Quantity Field (Pashe add kora holo) --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Stock / Quantity</label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" min="1"
                        class="w-full bg-slate-50 border-2 border-transparent rounded-2xl p-4 focus:bg-white focus:border-blue-500 outline-none transition-all font-bold text-blue-900 shadow-inner" 
                        placeholder="Ex: 1" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Department Dropdown --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Department</label>
                    <select name="department" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl p-4 focus:bg-white focus:border-blue-500 outline-none transition-all font-bold text-slate-600 shadow-inner cursor-pointer" required>
                        <option value="">Select Department</option>
                        <option value="SWE" {{ old('department') == 'SWE' ? 'selected' : '' }} class="font-black text-blue-600">SWE (Software Engineering) ⭐</option>
                        
                        <optgroup label="Faculty of Science & IT">
                            <option value="CSE" {{ old('department') == 'CSE' ? 'selected' : '' }}>CSE</option>
                            <option value="CIS" {{ old('department') == 'CIS' ? 'selected' : '' }}>CIS</option>
                            <option value="MCT" {{ old('department') == 'MCT' ? 'selected' : '' }}>MCT</option>
                            <option value="ITM" {{ old('department') == 'ITM' ? 'selected' : '' }}>ITM</option>
                            <option value="ICE" {{ old('department') == 'ICE' ? 'selected' : '' }}>ICE</option>
                        </optgroup>

                        <optgroup label="Business & Entrepreneurship">
                            <option value="BBA" {{ old('department') == 'BBA' ? 'selected' : '' }}>BBA</option>
                            <option value="Innovation & Entrepreneurship" {{ old('department') == 'Innovation & Entrepreneurship' ? 'selected' : '' }}>Innovation & Entrepreneurship</option>
                            <option value="Real Estate" {{ old('department') == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
                            <option value="THM" {{ old('department') == 'THM' ? 'selected' : '' }}>THM</option>
                        </optgroup>

                        <optgroup label="Engineering">
                            <option value="Civil" {{ old('department') == 'Civil' ? 'selected' : '' }}>Civil</option>
                            <option value="EEE" {{ old('department') == 'EEE' ? 'selected' : '' }}>EEE</option>
                            <option value="Textile" {{ old('department') == 'Textile' ? 'selected' : '' }}>Textile</option>
                            <option value="Architecture" {{ old('department') == 'Architecture' ? 'selected' : '' }}>Architecture</option>
                        </optgroup>

                        <optgroup label="Allied Health Science">
                            <option value="Pharmacy" {{ old('department') == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                            <option value="NFE" {{ old('department') == 'NFE' ? 'selected' : '' }}>NFE</option>
                            <option value="Public Health" {{ old('department') == 'Public Health' ? 'selected' : '' }}>Public Health</option>
                            <option value="Genetic Engineering" {{ old('department') == 'Genetic Engineering' ? 'selected' : '' }}>Genetic Engineering</option>
                        </optgroup>

                        <optgroup label="Humanities & Social Science">
                            <option value="English" {{ old('department') == 'English' ? 'selected' : '' }}>English</option>
                            <option value="Law" {{ old('department') == 'Law' ? 'selected' : '' }}>Law</option>
                            <option value="JMC" {{ old('department') == 'JMC' ? 'selected' : '' }}>JMC</option>
                            <option value="ESDM" {{ old('department') == 'ESDM' ? 'selected' : '' }}>ESDM</option>
                            <option value="PESS" {{ old('department') == 'PESS' ? 'selected' : '' }}>PESS</option>
                        </optgroup>

                        <option value="Agriculture" {{ old('department') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                    </select>
                </div>

                {{-- Pickup Point Dropdown --}}
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Pickup Point (Smart City)</label>
                    <select name="pickup_point" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl p-4 focus:bg-white focus:border-blue-500 outline-none transition-all font-bold text-slate-600 shadow-inner cursor-pointer" required>
                        <option value="">Select a location</option>
                        <optgroup label="Main Campus Area">
                            <option value="AB4" {{ old('pickup_point') == 'AB4' ? 'selected' : '' }}>AB4 (Main Building)</option>
                            <option value="AB1" {{ old('pickup_point') == 'AB1' ? 'selected' : '' }}>AB1</option>
                            <option value="8no Gate" {{ old('pickup_point') == '8no Gate' ? 'selected' : '' }}>8no Gate</option>
                            <option value="GATE no -2" {{ old('pickup_point') == 'GATE no -2' ? 'selected' : '' }}>Gate no -2</option>
                            <option value="Auditorium" {{ old('pickup_point') == 'Auditorium' ? 'selected' : '' }}>Auditorium</option>
                            <option value="Lake par" {{ old('pickup_point') == 'Lake par' ? 'selected' : '' }}>Lake Par</option>
                            <option value="Dadur Tong" {{ old('pickup_point') == 'Dadur Tong' ? 'selected' : '' }}>Dadur Tong ☕</option>
                            <option value="Admission building" {{ old('pickup_point') == 'Admission building' ? 'selected' : '' }}>Admission Building</option>
                        </optgroup>
                        <optgroup label="Nearby Campus Areas">
                            <option value="Khagan" {{ old('pickup_point') == 'Khagan' ? 'selected' : '' }}>Khagan</option>
                            <option value="Dattapara" {{ old('pickup_point') == 'Dattapara' ? 'selected' : '' }}>Dattapara</option>
                        </optgroup>
                        <optgroup label="Student Halls / Dorms">
                            <option value="YKGS 1" {{ old('pickup_point') == 'YKGS 1' ? 'selected' : '' }}>YKGS 1</option>
                            <option value="YKGS-2" {{ old('pickup_point') == 'YKGS-2' ? 'selected' : '' }}>YKGS-2</option>
                            <option value="RASG-1" {{ old('pickup_point') == 'RASG-1' ? 'selected' : '' }}>RASG-1</option>
                            <option value="RASG-2" {{ old('pickup_point') == 'RASG-2' ? 'selected' : '' }}>RASG-2</option>
                            <option value="GREEN GARDEN" {{ old('pickup_point') == 'GREEN GARDEN' ? 'selected' : '' }}>Green Garden</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            {{-- Product Description --}}
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Product Description (Important)</label>
                <textarea name="description" rows="4" 
                    class="w-full bg-slate-50 border-2 border-transparent rounded-2xl p-4 focus:bg-white focus:border-blue-500 outline-none transition-all font-bold text-blue-900 shadow-inner resize-none"
                    placeholder="Describe your item (e.g. Condition, how old, any issues?)" required>{{ old('description') }}</textarea>
            </div>

            {{-- Image Upload --}}
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase ml-2 mb-2">Product Image</label>
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-blue-400 transition-all shadow-inner">
                    <input type="file" name="image" id="imageInput" class="hidden" accept="image/*" required>
                    <label for="imageInput" class="cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-blue-400 mb-2"></i>
                        <p class="text-sm font-bold text-slate-500">Click to upload product photo</p>
                        <p class="text-[10px] text-slate-400 uppercase mt-1">PNG, JPG or JPEG (Max 2MB)</p>
                    </label>
                    <div id="imagePreview" class="mt-4 hidden">
                        <img src="" class="mx-auto h-32 w-32 object-cover rounded-xl shadow-md border-2 border-white">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white font-black py-5 rounded-[1.5rem] hover:bg-orange-600 transition-all shadow-xl transform hover:-translate-y-1">
                <i class="fa-solid fa-rocket mr-2"></i> UPLOAD PRODUCT
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('imageInput').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            preview.classList.remove('hidden');
            preview.querySelector('img').src = URL.createObjectURL(file);
        }
    }
</script>
@endsection