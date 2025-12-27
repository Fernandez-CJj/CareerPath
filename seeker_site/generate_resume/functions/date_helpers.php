<?php

/**
 * Convert a variety of date inputs to "F Y" (e.g. "August 2027").
 * Uses only built-in PHP functions (`strtotime` and `DateTime`).
 */
function convertToMonthYear(string $input): string
{
  $input = trim($input);
  if ($input === '') return '';

  // Try flexible parsing first (handles YYYY-MM-DD, YYYY-MM, "Aug 2027", etc.)
  $ts = strtotime($input);
  if ($ts !== false) {
    return date('F Y', $ts);
  }

  // Try explicit Year-Month format
  $dt = DateTime::createFromFormat('Y-m', $input);
  if ($dt !== false) {
    return $dt->format('F Y');
  }

  // Try explicit Year-Month-Day format
  $dt2 = DateTime::createFromFormat('Y-m-d', $input);
  if ($dt2 !== false) {
    return $dt2->format('F Y');
  }

  // If all parsing fails, return original input so it's visible for debugging
  return $input;
}
