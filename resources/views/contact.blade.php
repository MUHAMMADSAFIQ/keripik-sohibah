@extends('layouts.app')

@section('content')
@section('content')
<section class="container" style="padding-top: 8rem; padding-bottom: 5rem;">
    <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
        <span style="color: var(--secondary); font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">Get In Touch</span>
        <h1 style="font-size: 3rem; margin-top: 0.5rem; background: linear-gradient(120deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Hubungi Kami</h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto;">Punya pertanyaan, saran, atau ingin memesan dalam jumlah besar? Tim kami siap membantu Anda.</p>
    </div>

    <div class="grid reveal" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 3rem;">
        
        <!-- Contact Form -->
        <div class="glass-panel" style="padding: 2.5rem; border-radius: 24px;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                 <div style="width: 50px; height: 50px; background: rgba(0, 174, 213, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">✉️</div>
                 <h3 style="margin: 0;">Kirim Pesan</h3>
            </div>
            
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso" style="border-radius: 12px; padding: 12px 16px;">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label>Email (Opsional)</label>
                        <input type="email" name="email" placeholder="email@contoh.com" style="border-radius: 12px; padding: 12px 16px;">
                    </div>
                    <div>
                        <label>No. WhatsApp</label>
                        <input type="text" name="phone" placeholder="08..." style="border-radius: 12px; padding: 12px 16px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 2rem;">
                     <label>Isi Pesan</label>
                    <textarea name="message" rows="5" required placeholder="Tulis pesan Anda di sini..." style="border-radius: 12px; padding: 12px 16px;"></textarea>
                </div>
                
                <button type="submit" class="btn" style="width: 100%; padding: 14px; border-radius: 12px; font-size: 1.1rem;">Kirim Pesan sekarang</button>
            </form>
        </div>
        
        <!-- Info & Map -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Info Cards -->
            <div class="glass-panel" style="padding: 2rem; border-radius: 24px; display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 60px; height: 60px; background: rgba(37, 211, 102, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#25D366"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.6 1.967.603 4.607.72 4.664.214.104 1.25.666 4.3 2.197l-1.041 3.013 2.51-.664z"/></svg>
                </div>
                <div>
                    <h4 style="margin: 0 0 5px 0;">WhatsApp Admin</h4>
                    <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Respon Cepat (08:00 - 21:00)</p>
                    <a href="https://wa.me/6285643527635" target="_blank" style="color: var(--primary); font-weight: bold; text-decoration: none; display: inline-block; margin-top: 5px;">+62 856-4352-7635</a>
                </div>
            </div>

            <!-- Map -->
            <div class="glass-panel" style="padding: 1rem; border-radius: 24px; flex: 1; min-height: 300px; display: flex; flex-direction: column;">
                <h4 style="margin: 1rem; text-align: center;">Lokasi Toko</h4>
                <div style="flex: 1; border-radius: 16px; overflow: hidden; background: #334155;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d506230.08700194274!2d109.63464843323553!3d-7.5834090127458245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7abe05aaaaaaab%3A0x62a8dd962c4d3cd1!2sMASJID%20ASSU&#39;ADA!5e0!3m2!1sid!2sid!4v1767864667040!5m2!1sid!2sid" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
                <div style="text-align: center; margin-top: 1rem;">
                    <a href="https://goo.gl/maps/xyz" target="_blank" class="btn" style="background: transparent; border: 1px solid var(--glass-border); color: var(--text-muted); padding: 8px 20px; font-size: 0.9rem;">Buka di Google Maps</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
