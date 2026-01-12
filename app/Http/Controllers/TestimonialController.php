<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_approved', true)->latest()->get();
        return view('testimonials', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
             'customer_name' => 'required',
             'content' => 'required',
             'rating' => 'required|integer|min:1|max:5'
        ]);

        Testimonial::create($request->all());

        return back()->with('success', 'Terima kasih atas masukan Anda! Testimoni akan muncul setelah disetujui admin.');
    }
}
