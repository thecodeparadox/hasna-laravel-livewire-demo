<?php

namespace App\Enums;

enum PostStatus: string
{
  case PUBLISHED = 'PUBLISHED';
  case UNPUBLISHED = 'UNPUBLISHED';
  case DRAFT = 'DRAFT';

  public static function getColor(string | self $value): string
  {
    if (is_string($value)) {
      return match ($value) {
        self::DRAFT->value => 'warning',
        self::PUBLISHED->value => 'success',
        self::UNPUBLISHED->value => 'danger',
        default => 'secondary'
      };
    }

    return match ($value) {
      self::DRAFT => 'warning',
      self::PUBLISHED => 'success',
      self::UNPUBLISHED => 'danger',
      default => 'secondary'
    };
  }

  /**
   * Get Post statues enum values
   *
   * @return array
   */
  public static function getEnumValues(): array
  {
    return array_map(fn (self $status) => strval($status->value), self::cases());
  }

  /**
   * Get Status Case
   *
   * @param PostStatus|string $status
   * @return string
   */
  public static function getCase(self | string $status): PostStatus
  {
    if (is_string($status)) {
      $status = self::tryFrom($status);
    }

    return $status ?? self::DRAFT;
  }

  /**
   * Get String value of an Enum case
   *
   * @param PostStatus|string $status
   * @return string
   */
  public static function getValue(self | string $status): string
  {
    if (is_string($status)) {
      $status = self::getCase($status);
    }

    return $status->value;
  }

  /**
   * Check if status matched
   *
   * @param PostStatus|string $status
   * @param PostStatus|string $match
   * @return bool
   */
  public static function is(self | string $status, self | string $match): bool
  {
    return self::getValue($status) === self::getValue($match);
  }
}
