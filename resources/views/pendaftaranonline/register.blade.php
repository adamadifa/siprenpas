<!DOCTYPE html>
<html lang="en" x-data="{ isSignIn: true }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login/Register Animated</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
        .transition-transform {
            transition: transform 0.6s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="relative w-[900px] h-auto bg-white shadow-2xl rounded-xl overflow-hidden">

        <!-- Forms Container -->
        <div class="w-[100%] h-full flex ">
            <!-- Sign In Form -->
            <div class="w-1/2 p-10 flex flex-col justify-center bg-white">
                <h2 class="text-3xl font-bold text-teal-500 mb-6">Sign In</h2>
                <form class="space-y-4">
                    <input type="text" placeholder="Username"
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-teal-500" />
                    <input type="password" placeholder="Password"
                        class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-teal-500" />
                    <button
                        class="w-full bg-teal-500 text-white py-2 rounded-full font-semibold hover:bg-teal-600 transition">
                        SIGN IN
                    </button>
                </form>
            </div>
            <div class="w-1/2 p-10 flex flex-col justify-center bg-white">
                <h2 class="text-3xl font-bold text-teal-500 mb-4">Create Account</h2>

                <div class="flex gap-4 mb-4">
                    <div
                        class="w-10 h-10 rounded-full border flex items-center justify-center hover:bg-gray-100 cursor-pointer">
                        F</div>
                    <div
                        class="w-10 h-10 rounded-full border flex items-center justify-center hover:bg-gray-100 cursor-pointer">
                        G</div>
                    <div
                        class="w-10 h-10 rounded-full border flex items-center justify-center hover:bg-gray-100 cursor-pointer">
                        in</div>
                </div>

                <p class="text-sm text-gray-500 mb-4">or use your email for registration:</p>

                <div x-data="signUpForm()" class="space-y-4">

                    <!-- Name -->
                    <div>
                        <div
                            :class="['flex items-center border rounded px-3 py-2', errors.name ? 'border-red-500' : '']">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A10.97 10.97 0 0112 15c2.21 0 4.254.642 5.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="text" placeholder="Full Name" class="w-full outline-none"
                                x-model="form.name" @input="clearError('name')" />
                        </div>
                        <p x-show="errors.name" class="text-sm text-red-500 mt-1" x-text="errors.name"></p>
                    </div>

                    <!-- Email -->
                    <div>
                        <div
                            :class="['flex items-center border rounded px-3 py-2', errors.email ? 'border-red-500' : '']">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 12H8m8 0a4 4 0 00-8 0m8 0a4 4 0 01-8 0m8 0a4 4 0 00-8 0" />
                            </svg>
                            <input type="email" placeholder="Email" class="w-full outline-none" x-model="form.email"
                                @input="clearError('email')" />
                        </div>
                        <p x-show="errors.email" class="text-sm text-red-500 mt-1" x-text="errors.email"></p>
                    </div>

                    <!-- Password -->
                    <div>
                        <div
                            :class="['flex items-center border rounded px-3 py-2', errors.password ? 'border-red-500' : '']">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A10.97 10.97 0 0112 15c2.21 0 4.254.642 5.879 1.804" />
                            </svg>
                            <input type="password" placeholder="Password" class="w-full outline-none"
                                x-model="form.password" @input="clearError('password')" />
                        </div>
                        <p x-show="errors.password" class="text-sm text-red-500 mt-1" x-text="errors.password"></p>
                    </div>

                    <!-- Unit -->
                    <div>
                        <div
                            :class="['flex items-center border rounded px-3 py-2', errors.unit ? 'border-red-500' : '']">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h4l3-3 4 4 5-5v12H3z" />
                            </svg>
                            <select class="w-full outline-none bg-white text-gray-500" x-model="form.unit"
                                @change="clearError('unit')">
                                <option value="">Pilih Unit</option>
                                <option>TK</option>
                                <option>SDIT</option>
                                <option>MDU</option>
                                <option>MTs</option>
                                <option>MA</option>
                            </select>
                        </div>
                        <p x-show="errors.unit" class="text-sm text-red-500 mt-1" x-text="errors.unit"></p>
                    </div>

                    <!-- Asal Sekolah -->
                    <div>
                        <div
                            :class="['flex items-center border rounded px-3 py-2', errors.school ? 'border-red-500' : '']">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                            </svg>
                            <input type="text" placeholder="Asal Sekolah" class="w-full outline-none"
                                x-model="form.school" @input="clearError('school')" />
                        </div>
                        <p x-show="errors.school" class="text-sm text-red-500 mt-1" x-text="errors.school"></p>
                    </div>

                    <!-- No HP -->
                    <div>
                        <div
                            :class="['flex items-center border rounded px-3 py-2', errors.phone ? 'border-red-500' : '']">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.684l1.35 4.05a1 1 0 01-.342 1.092l-2.12 1.59a11.042 11.042 0 005.516 5.516l1.59-2.12a1 1 0 011.092-.342l4.05 1.35a1 1 0 01.684.95V19a2 2 0 01-2 2h-1C10.716 21 3 13.284 3 4V5z" />
                            </svg>
                            <input type="tel" placeholder="No. HP" class="w-full outline-none"
                                x-model="form.phone" @input="clearError('phone')" />
                        </div>
                        <p x-show="errors.phone" class="text-sm text-red-500 mt-1" x-text="errors.phone"></p>
                    </div>

                    <!-- Submit -->
                    <button @click.prevent="submitForm"
                        class="w-full bg-teal-500 text-white py-2 rounded-full font-semibold hover:bg-teal-600 transition">
                        SIGN UP
                    </button>
                </div>



            </div>
        </div>

        <!-- Panel Info (Sliding Box) -->
        <div class="absolute top-0 left-0 w-1/2 h-full  bg-teal-500 text-white flex flex-col items-center justify-center p-10 z-10 transition-transform duration-700"
            :class="{ 'translate-x-full': !isSignIn }">
            <template x-if="isSignIn">
                <div class="text-center">
                    <h2 class="text-3xl font-bold mb-2">Welcome Back!</h2>
                    <p class="mb-6">To keep connected with us please login with your personal info</p>
                    <button @click="isSignIn = false"
                        class="px-6 py-2 border border-white rounded-full hover:bg-white hover:text-teal-500 transition">
                        SIGN UP
                    </button>
                </div>
            </template>

            <template x-if="!isSignIn">
                <div class="text-center">
                    <h2 class="text-3xl font-bold mb-2">Hello, Friend!</h2>
                    <p class="mb-6">Enter your details and start your journey with us</p>
                    <button @click="isSignIn = true"
                        class="px-6 py-2 border border-white rounded-full hover:bg-white hover:text-teal-500 transition">
                        SIGN IN
                    </button>
                </div>
            </template>
        </div>

    </div>
    <script>
        function signUpForm() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    unit: '',
                    school: '',
                    phone: ''
                },
                errors: {},
                submitForm() {
                    this.errors = {};

                    // Validasi nama
                    if (!this.form.name) {
                        this.errors.name = 'Nama tidak boleh kosong.';
                    }

                    // Validasi email kosong dan format
                    if (!this.form.email) {
                        this.errors.email = 'Email tidak boleh kosong.';
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
                        this.errors.email = 'Format email tidak valid.';
                    }

                    // Validasi password
                    if (!this.form.password) {
                        this.errors.password = 'Password wajib diisi.';
                    }

                    // Validasi unit
                    if (!this.form.unit) {
                        this.errors.unit = 'Pilih salah satu unit.';
                    }

                    // Validasi asal sekolah
                    if (!this.form.school) {
                        this.errors.school = 'Asal sekolah wajib diisi.';
                    }

                    // Validasi No. HP: tidak kosong dan hanya angka
                    if (!this.form.phone) {
                        this.errors.phone = 'Nomor HP wajib diisi.';
                    } else if (!/^\d+$/.test(this.form.phone)) {
                        this.errors.phone = 'Nomor HP harus berupa angka saja.';
                    }

                    // Jika tidak ada error, submit berhasil
                    if (Object.keys(this.errors).length === 0) {
                        alert('Form berhasil dikirim!');
                        // Di sini kamu bisa submit data ke server atau lanjut ke proses berikutnya
                    }
                },
                clearError(field) {
                    delete this.errors[field];
                }
            }
        }
    </script>



</body>

</html>
