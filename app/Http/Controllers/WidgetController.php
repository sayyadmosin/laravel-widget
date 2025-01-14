<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->is('widget/*')) {
                config(['session.driver' => 'array']);
            }
            return $next($request);
        });
    }

    public function render(Request $request)
    {
        // Add any configuration or data you want to pass to the widget
        $config = [
            'theme' => $request->get('theme', 'light'),
            'title' => $request->get('title', 'Laravel Widget'),
        ];

        return response()
            ->view('widgets.embed', compact('config'))
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, X-CSRF-TOKEN');
    }

    public function script()
    {
        return response()
            ->view('widgets.script')
            ->header('Content-Type', 'application/javascript');
    }

    public function styles()
    {
        return response()
            ->view('widgets.styles')
            ->header('Content-Type', 'text/css');
    }

    public function data()
    {
        return cache()->remember('widget-data', 3600, function () {
            return [
                'status' => 'success',
                'data' => [
                    // Your widget data here
                ]
            ];
        });
    }

    public function action(Request $request) /// this is main method which being called from snippet
    {
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Action completed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
} 