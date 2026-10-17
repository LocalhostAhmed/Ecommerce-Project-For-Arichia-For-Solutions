<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotificationController extends Controller
{
    /**
     * GET /api/notifications
     * List the user's database notifications.
     */
    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'unread_only' => ['sometimes', 'boolean'],
                'per_page'    => ['sometimes', 'integer', 'min:1', 'max:50'],
            ]);

            $query = $request->user()->notifications();

            if (!empty($validated['unread_only'])) {
                $query = $request->user()->unreadNotifications();
            }

            $notifications = $query
                ->paginate($validated['per_page'] ?? 15)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Notifications retrieved successfully.',
                'data'    => $notifications->items(),
                'unread_count' => $request->user()->unreadNotifications()->count(),
                'pagination' => [
                    'current_page' => $notifications->currentPage(),
                    'per_page'     => $notifications->perPage(),
                    'total'        => $notifications->total(),
                    'last_page'    => $notifications->lastPage(),
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Notification retrieval failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve notifications.',
            ], 500);
        }
    }

    /**
     * PATCH /api/notifications/{id}/read
     * Mark one notification as read.
     */
    public function markAsRead(Request $request, string $id)
    {
        try {
            $notification = $request->user()
                ->notifications()
                ->where('id', $id)
                ->firstOrFail();

            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read.',
            ]);
        } catch (Throwable $e) {
            Log::error('Mark notification read failed.', [
                'user_id'         => $request->user()?->id,
                'notification_id' => $id,
                'error'           => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to mark notification as read.',
            ], 500);
        }
    }

    /**
     * PATCH /api/notifications/read-all
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $request->user()->unreadNotifications()->update(['read_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read.',
            ]);
        } catch (Throwable $e) {
            Log::error('Mark all notifications read failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to mark all notifications as read.',
            ], 500);
        }
    }

    /**
     * DELETE /api/notifications/{id}
     * Delete one notification.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $notification = $request->user()
                ->notifications()
                ->where('id', $id)
                ->firstOrFail();

            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted.',
            ]);
        } catch (Throwable $e) {
            Log::error('Notification deletion failed.', [
                'user_id'         => $request->user()?->id,
                'notification_id' => $id,
                'error'           => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete notification.',
            ], 500);
        }
    }
}
