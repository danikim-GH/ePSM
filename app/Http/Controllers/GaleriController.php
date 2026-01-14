<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaleriController extends Controller
{
    public function galeri(Request $request)
    {
        // Pagination settings
        $perPage = 5; // Show 5 events per page
        $currentPage = $request->get('page', 1);

        // Fetch paginated events
        $galeriAcara = DB::table('galeri_acara')
            ->select('ID', 'eg_tajuk', 'eg_tarikh', 'eg_lokasi', 'eg_idmenu')
            ->orderBy('eg_tarikh', 'DESC')
            ->paginate($perPage);

        // Get event IDs from current page
        $eventIds = $galeriAcara->pluck('ID')->toArray();

        // Fetch images only for events on current page
        $galeriImages = DB::table('galeri')
            ->select('ID', 'gal_idevent', 'gal_caption', 'gal_fail', 'gal_sumber', 'gal_papar')
            ->whereIn('gal_idevent', $eventIds)
            ->where('gal_papar', 'Y') // Only show images with display flag = Y
            ->orderBy('ID', 'ASC')
            ->get()
            ->groupBy('gal_idevent'); // Group images by event ID

        // Get total counts for statistics
        $totalEvents = DB::table('galeri_acara')->count();
        $totalImages = DB::table('galeri')->where('gal_papar', 'Y')->count();

        return view('galeri', compact('galeriAcara', 'galeriImages', 'totalEvents', 'totalImages'));
    }

    // Optional: Method to get images for specific event (AJAX)
    public function getEventImages($eventId)
    {
        $images = DB::table('galeri')
            ->where('gal_idevent', $eventId)
            ->where('gal_papar', 'Y')
            ->get();

        return response()->json($images);
    }

    // Optional: Filter by year
    public function filterByYear($year)
    {
        $galeriAcara = DB::table('galeri_acara')
            ->select('ID', 'eg_tajuk', 'eg_tarikh', 'eg_lokasi', 'eg_idmenu')
            ->whereYear('eg_tarikh', $year)
            ->orderBy('eg_tarikh', 'DESC')
            ->paginate(5);

        $eventIds = $galeriAcara->pluck('ID')->toArray();

        $galeriImages = DB::table('galeri')
            ->select('ID', 'gal_idevent', 'gal_caption', 'gal_fail', 'gal_sumber', 'gal_papar')
            ->whereIn('gal_idevent', $eventIds)
            ->where('gal_papar', 'Y')
            ->orderBy('ID', 'ASC')
            ->get()
            ->groupBy('gal_idevent');

        $totalEvents = DB::table('galeri_acara')->whereYear('eg_tarikh', $year)->count();
        $totalImages = DB::table('galeri')
            ->whereIn('gal_idevent', $eventIds)
            ->where('gal_papar', 'Y')
            ->count();

        return view('galeri', compact('galeriAcara', 'galeriImages', 'totalEvents', 'totalImages'));
    }
}