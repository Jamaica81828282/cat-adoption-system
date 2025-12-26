@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 py-12 flex justify-center items-start">
    <div class="max-w-5xl w-full bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row">
        <!-- Left: Cat Image -->
        <div class="md:w-1/2 bg-gray-100 flex justify-center items-center p-6">
            @php
                $imagePath = ltrim($cat->image ?? '', '/');
            @endphp
            <img src="{{ Str::startsWith($imagePath, 'cats/') 
                    ? asset('storage/' . $imagePath)
                    : $cat->image }}" 
                alt="{{ $cat->name }}" 
                class="rounded-xl w-full max-w-sm object-cover shadow-md">
        </div>

        <!-- Right: Cat Info + Form -->
        <div class="md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-pink-600 mb-4">{{ $cat->name }}</h2>

            <ul class="text-gray-700 space-y-2 mb-6">
                <li><strong>Breed:</strong> {{ $cat->breed }}</li>
                <li><strong>Age:</strong> {{ $cat->age }} {{ Str::contains($cat->age, 'year') ? '' : 'year(s)' }}</li>
            </ul>

            <p class="text-gray-600 mb-6">{{ $cat->description }}</p>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Adoption Form -->
            <form action="{{ route('applications.store', $cat->id) }}" method="POST" class="space-y-4" id="adoptionForm">
                @csrf

                <div>
                    <label for="notes" class="block text-gray-700 font-medium mb-1">Additional Notes (optional):</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-pink-300">{{ old('notes') }}</textarea>
                </div>

                <!-- Application Fee Notice -->
                <div class="bg-pink-50 border border-pink-200 rounded-lg p-4">
                    <p class="text-pink-800 font-semibold text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                        Application Fee: ₱25.00
                    </p>
                    <p class="text-gray-600 text-xs mt-1">A small processing fee is required to submit your application.</p>
                </div>

                <!-- Payment Method Selection -->
                <div>
                    <label class="block text-gray-700 font-medium mb-3">Select Payment Method:</label>
                    
                    <div class="space-y-3">
                        <!-- GCash -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-pink-50 hover:border-pink-300 transition">
                            <input type="radio" name="payment_method" value="gcash" class="w-4 h-4 text-pink-500 focus:ring-pink-400" onchange="showPaymentDetails('gcash')" {{ old('payment_method') == 'gcash' ? 'checked' : '' }}>
                            <div class="ml-3 flex items-center">
                                <div class="bg-blue-500 text-white font-bold px-2 py-1 rounded text-xs mr-2">GCash</div>
                                <span class="text-gray-700 text-sm">Pay via GCash</span>
                            </div>
                        </label>

                        <!-- PayMaya -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-pink-50 hover:border-pink-300 transition">
                            <input type="radio" name="payment_method" value="paymaya" class="w-4 h-4 text-pink-500 focus:ring-pink-400" onchange="showPaymentDetails('paymaya')" {{ old('payment_method') == 'paymaya' ? 'checked' : '' }}>
                            <div class="ml-3 flex items-center">
                                <div class="bg-green-500 text-white font-bold px-2 py-1 rounded text-xs mr-2">Maya</div>
                                <span class="text-gray-700 text-sm">Pay via Maya (PayMaya)</span>
                            </div>
                        </label>

                        <!-- Bank Transfer -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-pink-50 hover:border-pink-300 transition">
                            <input type="radio" name="payment_method" value="bank_transfer" class="w-4 h-4 text-pink-500 focus:ring-pink-400" onchange="showPaymentDetails('bank_transfer')" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                            <div class="ml-3 flex items-center">
                                <div class="bg-purple-500 text-white font-bold px-2 py-1 rounded text-xs mr-2">Bank</div>
                                <span class="text-gray-700 text-sm">Bank Transfer</span>
                            </div>
                        </label>

                        <!-- Cash on Processing -->
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-pink-50 hover:border-pink-300 transition">
                            <input type="radio" name="payment_method" value="cash" class="w-4 h-4 text-pink-500 focus:ring-pink-400" onchange="showPaymentDetails('cash')" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                            <div class="ml-3 flex items-center">
                                <div class="bg-orange-500 text-white font-bold px-2 py-1 rounded text-xs mr-2">Cash</div>
                                <span class="text-gray-700 text-sm">Pay Cash on Processing</span>
                            </div>
                        </label>
                    </div>

                    @error('payment_method')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Details Section (Hidden by default) -->
                <div id="payment-details" class="hidden">
                    <!-- GCash Details -->
                    <div id="gcash-details" class="payment-detail hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-800 mb-2">GCash Payment Details</h4>
                        <p class="text-sm text-gray-700 mb-3">Send ₱25.00 to: <strong>0917-123-4567</strong></p>
                        <p class="text-sm text-gray-600 mb-2">Account Name: Cat Adoption Center</p>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reference Number:</label>
                        <input type="text" name="payment_reference_gcash" id="ref_gcash" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Enter GCash reference number" value="{{ old('payment_reference') }}">
                    </div>

                    <!-- PayMaya Details -->
                    <div id="paymaya-details" class="payment-detail hidden bg-green-50 border border-green-200 rounded-lg p-4">
                        <h4 class="font-semibold text-green-800 mb-2">Maya Payment Details</h4>
                        <p class="text-sm text-gray-700 mb-3">Send ₱25.00 to: <strong>0918-765-4321</strong></p>
                        <p class="text-sm text-gray-600 mb-2">Account Name: Cat Adoption Center</p>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reference Number:</label>
                        <input type="text" name="payment_reference_paymaya" id="ref_paymaya" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300" placeholder="Enter Maya reference number" value="{{ old('payment_reference') }}">
                    </div>

                    <!-- Bank Transfer Details -->
                    <div id="bank_transfer-details" class="payment-detail hidden bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <h4 class="font-semibold text-purple-800 mb-2">Bank Transfer Details</h4>
                        <p class="text-sm text-gray-700 mb-1"><strong>Bank:</strong> BDO</p>
                        <p class="text-sm text-gray-700 mb-1"><strong>Account Number:</strong> 1234-5678-9012</p>
                        <p class="text-sm text-gray-600 mb-3">Account Name: Cat Adoption Center</p>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reference Number:</label>
                        <input type="text" name="payment_reference_bank" id="ref_bank" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300" placeholder="Enter transaction reference number" value="{{ old('payment_reference') }}">
                    </div>

                    <!-- Cash Details -->
                    <div id="cash-details" class="payment-detail hidden bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <h4 class="font-semibold text-orange-800 mb-2">Cash Payment Information</h4>
                        <p class="text-sm text-gray-700 mb-2">You will pay ₱25.00 in cash when you come to process your adoption.</p>
                        <p class="text-sm text-gray-600">Our office is located at: <strong>123 Cat Street, Cebu City</strong></p>
                        <p class="text-sm text-gray-600 mt-1">Office Hours: Mon-Fri, 9:00 AM - 5:00 PM</p>
                        <input type="hidden" name="payment_reference_cash" value="N/A">
                    </div>
                </div>

                <div class="flex space-x-4 pt-2">
                    <button type="submit" 
                            class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition shadow-md">
                        Apply for Adoption 💕
                    </button>

                    <a href="{{ route('adopt.index') }}" 
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300 transition">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showPaymentDetails(method) {
    console.log('Payment method selected:', method);
    
    document.querySelectorAll('.payment-detail').forEach(detail => {
        detail.classList.add('hidden');
    });
    
    document.querySelectorAll('input[name^="payment_reference"]').forEach(input => {
        input.removeAttribute('required');
        input.disabled = true;
    });
    
    const detailsContainer = document.getElementById('payment-details');
    const selectedDetail = document.getElementById(method + '-details');
    
    if (selectedDetail) {
        detailsContainer.classList.remove('hidden');
        selectedDetail.classList.remove('hidden');
        
        const referenceInput = selectedDetail.querySelector('input[name^="payment_reference"]');
        if (referenceInput) {
            referenceInput.disabled = false;
            if (method !== 'cash') {
                referenceInput.setAttribute('required', 'required');
            }
        }
    }
}

document.getElementById('adoptionForm').addEventListener('submit', function(e) {
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
    
    if (!selectedMethod) {
        e.preventDefault();
        alert('Please select a payment method');
        return false;
    }
    
    const activeReferenceInput = document.querySelector(`input[name="payment_reference_${selectedMethod.value}"]:not([disabled])`);
    
    if (activeReferenceInput) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'payment_reference';
        hiddenInput.value = activeReferenceInput.value;
        this.appendChild(hiddenInput);
    }
    
    console.log('Form submitting...');
});

window.addEventListener('DOMContentLoaded', function() {
    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
    if (selectedMethod) {
        showPaymentDetails(selectedMethod.value);
    }
});
</script>
@endsection