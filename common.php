<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

session_start();

function jsonResponse(mixed $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
    exit;
}

function requestBody(): array
{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw ?: '{}', true);
    return is_array($data) ? $data : [];
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function requireUser(): array
{
    $user = currentUser();
    if (!$user) {
        jsonResponse(['error' => 'Please sign in first.'], 401);
    }
    return $user;
}

function requireRole(array $roles): array
{
    $user = requireUser();
    if (!in_array($user['role'], $roles, true)) {
        jsonResponse(['error' => 'You do not have permission for this action.'], 403);
    }
    return $user;
}

function cleanString(mixed $value, int $maxLength = 255): string
{
    return mb_substr(trim((string) $value), 0, $maxLength);
}

function normaliseUser(array $user): array
{
    return [
        'id' => (int) $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'phone' => $user['phone'] ?? null,
        'role' => $user['role'],
    ];
}

function parseDate(string $value): ?DateTimeImmutable
{
    try {
        return new DateTimeImmutable($value);
    } catch (Exception) {
        return null;
    }
}