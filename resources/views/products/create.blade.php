@extends('layouts.app')

@section('content')
    <div class="pt-[17px] pl-[18px]">
        <div class="relative w-[630px] h-[500px] bg-[#374050] border border-black">

            {{-- Title --}}
            <div class="absolute left-[12px] top-[57px] text-white font-bold text-[20px] leading-[11px]">
                Добавить продукт
            </div>

            {{-- Close --}}
            <a href="{{ route('products.index') }}"
               class="absolute left-[595px] top-[18px] w-[30px] h-[30px] flex items-center justify-center"
               title="Закрыть">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true">
                    <path d="M9 9L21 21" stroke="#C4C4C4" stroke-width="2" stroke-linecap="square"/>
                    <path d="M21 9L9 21" stroke="#C4C4C4" stroke-width="2" stroke-linecap="square"/>
                </svg>
            </a>

            {{-- Form --}}
            <form action="{{ route('products.store') }}" method="POST" class="px-[16px] py-[16px]">
                @csrf
                {{-- Product Article --}}
                <div class="mb-4">
                    <label for="article" class="text-white text-[9px]">Артикул</label>
                    <input type="text" name="article" id="article" class="w-full h-[30px] rounded-[5px] p-2 bg-white"
                           value="{{ old('article') }}">
                </div>

                {{-- Product Name --}}
                <div class="mb-4">
                    <label for="name" class="text-white text-[9px]">Название</label>
                    <input type="text" name="name" id="name" class="w-full h-[30px] rounded-[5px] p-2 bg-white"
                           value="{{ old('name') }}">
                </div>

                {{-- Product Status --}}
                <div class="mb-4">
                    <label for="status" class="text-white text-[9px]">Статус</label>
                    <select name="status" id="status" class="w-full h-[30px] rounded-[5px] p-2 bg-white">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Доступен</option>
                        <option value="unavailable" {{ old('status') === 'unavailable' ? 'selected' : '' }}>Не доступен</option>
                    </select>
                </div>

                {{-- Attributes --}}
                <div class="mb-4">
                    <div class="text-white text-[14px] font-bold mb-2">Атрибуты</div>
                    <div id="attributes-container">
                        {{-- Начинаем с пустого блока --}}
                    </div>
                    <button type="button" id="add-attribute" class="text-[#0FC5FF] text-[9px] hover:underline cursor-pointer">
                        + Добавить атрибут
                    </button>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-start mt-[20px]">
                    <button type="submit"
                            class="w-[139px] h-[30px] rounded-[5px] bg-[#0FC5FF] text-white text-[11px] cursor-pointer">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Кнопка добавления атрибута
            document.getElementById('add-attribute').addEventListener('click', function () {
                const container = document.getElementById('attributes-container');
                const newAttribute = document.createElement('div');
                newAttribute.classList.add('attribute-item', 'flex', 'items-center', 'mb-4');
                newAttribute.innerHTML = `
                    <input type="text" name="attributes[][name]" placeholder="Название атрибута"
                           class="w-[150px] h-[30px] rounded-[5px] p-2 bg-white">
                    <input type="text" name="attributes[][value]" placeholder="Значение"
                           class="w-[150px] h-[30px] rounded-[5px] p-2 bg-white ml-2">
                    <button type="button" class="remove-attribute ml-2">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M18 6L6 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 6L18 18" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                `;
                container.appendChild(newAttribute);
            });

            // Удаление атрибута
            document.getElementById('attributes-container').addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-attribute')) {
                    e.target.closest('.attribute-item').remove();
                }
            });
        });
    </script>
@endsection
