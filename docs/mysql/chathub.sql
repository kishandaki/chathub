-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 22, 2026 at 04:53 PM
-- Server version: 9.1.0
-- PHP Version: 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chathub`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_lock_logs`
--

DROP TABLE IF EXISTS `account_lock_logs`;
CREATE TABLE IF NOT EXISTS `account_lock_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `locked_by` bigint UNSIGNED DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_attempts` int UNSIGNED NOT NULL,
  `locked_until` timestamp NULL DEFAULT NULL,
  `unlocked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_lock_logs_user_id_locked_until_index` (`user_id`,`locked_until`),
  KEY `account_lock_logs_locked_by_index` (`locked_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_audit_logs`
--

DROP TABLE IF EXISTS `chat_audit_logs`;
CREATE TABLE IF NOT EXISTS `chat_audit_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `actor_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` bigint UNSIGNED DEFAULT NULL,
  `conversation_id` bigint UNSIGNED DEFAULT NULL,
  `message_id` bigint UNSIGNED DEFAULT NULL,
  `target_user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_audit_logs_uuid_unique` (`uuid`),
  KEY `chat_audit_logs_conversation_id_foreign` (`conversation_id`),
  KEY `chat_audit_logs_message_id_foreign` (`message_id`),
  KEY `chat_audit_org_created_idx` (`organization_id`,`created_at`),
  KEY `chat_audit_actor_created_idx` (`actor_id`,`created_at`),
  KEY `chat_audit_action_created_idx` (`action`,`created_at`),
  KEY `chat_audit_entity_idx` (`entity_type`,`entity_id`),
  KEY `chat_audit_logs_organization_id_index` (`organization_id`),
  KEY `chat_audit_logs_actor_id_index` (`actor_id`),
  KEY `chat_audit_logs_action_index` (`action`),
  KEY `chat_audit_logs_entity_type_index` (`entity_type`),
  KEY `chat_audit_logs_entity_id_index` (`entity_id`),
  KEY `chat_audit_logs_target_user_id_index` (`target_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_conversations`
--

DROP TABLE IF EXISTS `chat_conversations`;
CREATE TABLE IF NOT EXISTS `chat_conversations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'direct',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `avatar_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `encryption_mode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enterprise_recovery',
  `recovery_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_system_generated` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_message_id` bigint UNSIGNED DEFAULT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_conversations_uuid_unique` (`uuid`),
  KEY `chat_conv_org_type_status_idx` (`organization_id`,`type`,`status`),
  KEY `chat_conv_org_last_msg_idx` (`organization_id`,`last_message_at`),
  KEY `chat_conversations_organization_id_index` (`organization_id`),
  KEY `chat_conversations_type_index` (`type`),
  KEY `chat_conversations_reference_type_index` (`reference_type`),
  KEY `chat_conversations_reference_id_index` (`reference_id`),
  KEY `chat_conversations_encryption_mode_index` (`encryption_mode`),
  KEY `chat_conversations_recovery_enabled_index` (`recovery_enabled`),
  KEY `chat_conversations_is_system_generated_index` (`is_system_generated`),
  KEY `chat_conversations_status_index` (`status`),
  KEY `chat_conversations_last_message_id_index` (`last_message_id`),
  KEY `chat_conversations_last_message_at_index` (`last_message_at`),
  KEY `chat_conversations_created_by_index` (`created_by`),
  KEY `chat_conversations_updated_by_index` (`updated_by`),
  KEY `chat_conversations_deleted_by_index` (`deleted_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_conversation_members`
--

DROP TABLE IF EXISTS `chat_conversation_members`;
CREATE TABLE IF NOT EXISTS `chat_conversation_members` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `member_role` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `can_send` tinyint(1) NOT NULL DEFAULT '1',
  `can_upload` tinyint(1) NOT NULL DEFAULT '1',
  `is_muted` tinyint(1) NOT NULL DEFAULT '0',
  `last_read_message_id` bigint UNSIGNED DEFAULT NULL,
  `last_read_at` timestamp NULL DEFAULT NULL,
  `unread_count` int UNSIGNED NOT NULL DEFAULT '0',
  `encryption_join_version` int UNSIGNED DEFAULT NULL,
  `joined_at` timestamp NULL DEFAULT NULL,
  `left_at` timestamp NULL DEFAULT NULL,
  `removed_by` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_members_conversation_user_unique` (`conversation_id`,`user_id`),
  UNIQUE KEY `chat_conversation_members_uuid_unique` (`uuid`),
  KEY `chat_members_user_left_idx` (`user_id`,`left_at`),
  KEY `chat_members_conv_role_idx` (`conversation_id`,`member_role`),
  KEY `chat_conversation_members_user_id_index` (`user_id`),
  KEY `chat_conversation_members_member_role_index` (`member_role`),
  KEY `chat_conversation_members_is_muted_index` (`is_muted`),
  KEY `chat_conversation_members_last_read_message_id_index` (`last_read_message_id`),
  KEY `chat_conversation_members_joined_at_index` (`joined_at`),
  KEY `chat_conversation_members_left_at_index` (`left_at`),
  KEY `chat_conversation_members_removed_by_index` (`removed_by`),
  KEY `chat_conversation_members_created_by_index` (`created_by`),
  KEY `chat_conversation_members_updated_by_index` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_deleted_messages`
--

DROP TABLE IF EXISTS `chat_deleted_messages`;
CREATE TABLE IF NOT EXISTS `chat_deleted_messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `delete_scope` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'for_me',
  `reason` text COLLATE utf8mb4_unicode_ci,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_deleted_conv_deleted_idx` (`conversation_id`,`deleted_at`),
  KEY `chat_deleted_message_scope_idx` (`message_id`,`delete_scope`),
  KEY `chat_deleted_messages_user_id_index` (`user_id`),
  KEY `chat_deleted_messages_delete_scope_index` (`delete_scope`),
  KEY `chat_deleted_messages_deleted_by_index` (`deleted_by`),
  KEY `chat_deleted_messages_deleted_at_index` (`deleted_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_encryption_keys`
--

DROP TABLE IF EXISTS `chat_encryption_keys`;
CREATE TABLE IF NOT EXISTS `chat_encryption_keys` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `owner_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` bigint UNSIGNED DEFAULT NULL,
  `key_purpose` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` longtext COLLATE utf8mb4_unicode_ci,
  `encrypted_private_key` longtext COLLATE utf8mb4_unicode_ci,
  `wrapped_key_metadata` json DEFAULT NULL,
  `key_version` int UNSIGNED NOT NULL DEFAULT '1',
  `algorithm` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_until` timestamp NULL DEFAULT NULL,
  `rotated_from_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `revoked_by` bigint UNSIGNED DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_encryption_keys_uuid_unique` (`uuid`),
  KEY `chat_keys_owner_purpose_idx` (`owner_type`,`owner_id`,`key_purpose`),
  KEY `chat_keys_org_status_idx` (`organization_id`,`status`),
  KEY `chat_keys_purpose_version_idx` (`key_purpose`,`key_version`),
  KEY `chat_encryption_keys_organization_id_index` (`organization_id`),
  KEY `chat_encryption_keys_owner_type_index` (`owner_type`),
  KEY `chat_encryption_keys_owner_id_index` (`owner_id`),
  KEY `chat_encryption_keys_key_purpose_index` (`key_purpose`),
  KEY `chat_encryption_keys_key_version_index` (`key_version`),
  KEY `chat_encryption_keys_status_index` (`status`),
  KEY `chat_encryption_keys_valid_from_index` (`valid_from`),
  KEY `chat_encryption_keys_valid_until_index` (`valid_until`),
  KEY `chat_encryption_keys_rotated_from_id_index` (`rotated_from_id`),
  KEY `chat_encryption_keys_created_by_index` (`created_by`),
  KEY `chat_encryption_keys_revoked_by_index` (`revoked_by`),
  KEY `chat_encryption_keys_revoked_at_index` (`revoked_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_fcm_configurations`
--

DROP TABLE IF EXISTS `chat_fcm_configurations`;
CREATE TABLE IF NOT EXISTS `chat_fcm_configurations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `project_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vapid_public_key` text COLLATE utf8mb4_unicode_ci,
  `vapid_private_key_encrypted` longtext COLLATE utf8mb4_unicode_ci,
  `service_account_json_encrypted` longtext COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_tested_at` timestamp NULL DEFAULT NULL,
  `last_test_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_test_error` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_fcm_configurations_uuid_unique` (`uuid`),
  UNIQUE KEY `chat_fcm_org_project_unique` (`organization_id`,`project_id`),
  KEY `chat_fcm_org_active_idx` (`organization_id`,`is_active`),
  KEY `chat_fcm_configurations_organization_id_index` (`organization_id`),
  KEY `chat_fcm_configurations_is_active_index` (`is_active`),
  KEY `chat_fcm_configurations_created_by_index` (`created_by`),
  KEY `chat_fcm_configurations_updated_by_index` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED DEFAULT NULL,
  `parent_message_id` bigint UNSIGNED DEFAULT NULL,
  `message_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `encrypted_payload` longtext COLLATE utf8mb4_unicode_ci,
  `payload_hash` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encryption_mode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enterprise_recovery',
  `encryption_version` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nonce` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aad` json DEFAULT NULL,
  `payload_size` int UNSIGNED DEFAULT NULL,
  `is_edited` tinyint(1) NOT NULL DEFAULT '0',
  `edited_at` timestamp NULL DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `sent_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_messages_uuid_unique` (`uuid`),
  KEY `chat_messages_conv_id_idx` (`conversation_id`,`id`),
  KEY `chat_messages_conv_created_idx` (`conversation_id`,`created_at`),
  KEY `chat_messages_sender_created_idx` (`sender_id`,`created_at`),
  KEY `chat_messages_conv_type_idx` (`conversation_id`,`message_type`),
  KEY `chat_messages_sender_id_index` (`sender_id`),
  KEY `chat_messages_parent_message_id_index` (`parent_message_id`),
  KEY `chat_messages_message_type_index` (`message_type`),
  KEY `chat_messages_payload_hash_index` (`payload_hash`),
  KEY `chat_messages_encryption_mode_index` (`encryption_mode`),
  KEY `chat_messages_is_edited_index` (`is_edited`),
  KEY `chat_messages_is_system_index` (`is_system`),
  KEY `chat_messages_sent_at_index` (`sent_at`),
  KEY `chat_messages_deleted_by_index` (`deleted_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_message_attachments`
--

DROP TABLE IF EXISTS `chat_message_attachments`;
CREATE TABLE IF NOT EXISTS `chat_message_attachments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `storage_disk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime_type` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint UNSIGNED NOT NULL DEFAULT '0',
  `file_hash` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encrypted_file_key` longtext COLLATE utf8mb4_unicode_ci,
  `nonce` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `scan_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `scan_result` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_message_attachments_uuid_unique` (`uuid`),
  KEY `chat_message_attachments_message_id_foreign` (`message_id`),
  KEY `chat_attach_conv_created_idx` (`conversation_id`,`created_at`),
  KEY `chat_attach_uploader_created_idx` (`uploaded_by`,`created_at`),
  KEY `chat_message_attachments_uploaded_by_index` (`uploaded_by`),
  KEY `chat_message_attachments_storage_disk_index` (`storage_disk`),
  KEY `chat_message_attachments_mime_type_index` (`mime_type`),
  KEY `chat_message_attachments_file_hash_index` (`file_hash`),
  KEY `chat_message_attachments_preview_status_index` (`preview_status`),
  KEY `chat_message_attachments_scan_status_index` (`scan_status`),
  KEY `chat_message_attachments_deleted_by_index` (`deleted_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_message_key_recipients`
--

DROP TABLE IF EXISTS `chat_message_key_recipients`;
CREATE TABLE IF NOT EXISTS `chat_message_key_recipients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_id` bigint UNSIGNED NOT NULL,
  `recipient_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_id` bigint UNSIGNED DEFAULT NULL,
  `encryption_key_id` bigint UNSIGNED DEFAULT NULL,
  `encrypted_message_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_version` int UNSIGNED NOT NULL DEFAULT '1',
  `algorithm` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nonce` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_msg_key_recipient_unique` (`message_id`,`recipient_type`,`recipient_id`),
  KEY `chat_message_key_recipients_encryption_key_id_foreign` (`encryption_key_id`),
  KEY `chat_msg_key_recipient_idx` (`recipient_type`,`recipient_id`),
  KEY `chat_msg_key_message_version_idx` (`message_id`,`key_version`),
  KEY `chat_message_key_recipients_recipient_type_index` (`recipient_type`),
  KEY `chat_message_key_recipients_recipient_id_index` (`recipient_id`),
  KEY `chat_message_key_recipients_key_version_index` (`key_version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_message_statuses`
--

DROP TABLE IF EXISTS `chat_message_statuses`;
CREATE TABLE IF NOT EXISTS `chat_message_statuses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `delivered_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  `failure_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_msg_status_message_user_unique` (`message_id`,`user_id`),
  KEY `chat_msg_status_user_status_idx` (`user_id`,`status`),
  KEY `chat_msg_status_message_status_idx` (`message_id`,`status`),
  KEY `chat_message_statuses_user_id_index` (`user_id`),
  KEY `chat_message_statuses_status_index` (`status`),
  KEY `chat_message_statuses_delivered_at_index` (`delivered_at`),
  KEY `chat_message_statuses_read_at_index` (`read_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_muted_conversations`
--

DROP TABLE IF EXISTS `chat_muted_conversations`;
CREATE TABLE IF NOT EXISTS `chat_muted_conversations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `muted_until` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_muted_conversation_user_unique` (`conversation_id`,`user_id`),
  KEY `chat_muted_user_until_idx` (`user_id`,`muted_until`),
  KEY `chat_muted_conversations_user_id_index` (`user_id`),
  KEY `chat_muted_conversations_muted_until_index` (`muted_until`),
  KEY `chat_muted_conversations_created_by_index` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_notification_deliveries`
--

DROP TABLE IF EXISTS `chat_notification_deliveries`;
CREATE TABLE IF NOT EXISTS `chat_notification_deliveries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED DEFAULT NULL,
  `message_id` bigint UNSIGNED DEFAULT NULL,
  `event_type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `provider_message_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `safe_title` text COLLATE utf8mb4_unicode_ci,
  `safe_body` text COLLATE utf8mb4_unicode_ci,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `retry_count` smallint UNSIGNED NOT NULL DEFAULT '0',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_notification_deliveries_uuid_unique` (`uuid`),
  KEY `chat_notification_deliveries_conversation_id_foreign` (`conversation_id`),
  KEY `chat_notification_deliveries_message_id_foreign` (`message_id`),
  KEY `chat_notif_delivery_user_status_created_idx` (`user_id`,`status`,`created_at`),
  KEY `chat_notif_delivery_org_channel_status_idx` (`organization_id`,`channel`,`status`),
  KEY `chat_notification_deliveries_organization_id_index` (`organization_id`),
  KEY `chat_notification_deliveries_user_id_index` (`user_id`),
  KEY `chat_notification_deliveries_event_type_index` (`event_type`),
  KEY `chat_notification_deliveries_channel_index` (`channel`),
  KEY `chat_notification_deliveries_status_index` (`status`),
  KEY `chat_notification_deliveries_provider_message_id_index` (`provider_message_id`),
  KEY `chat_notification_deliveries_scheduled_at_index` (`scheduled_at`),
  KEY `chat_notification_deliveries_sent_at_index` (`sent_at`),
  KEY `chat_notification_deliveries_read_at_index` (`read_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_notification_preferences`
--

DROP TABLE IF EXISTS `chat_notification_preferences`;
CREATE TABLE IF NOT EXISTS `chat_notification_preferences` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `event_type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `muted_until` timestamp NULL DEFAULT NULL,
  `rules` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_notif_pref_user_event_channel_unique` (`user_id`,`event_type`,`channel`),
  KEY `chat_notif_pref_org_event_channel_idx` (`organization_id`,`event_type`,`channel`),
  KEY `chat_notification_preferences_organization_id_index` (`organization_id`),
  KEY `chat_notification_preferences_user_id_index` (`user_id`),
  KEY `chat_notification_preferences_event_type_index` (`event_type`),
  KEY `chat_notification_preferences_channel_index` (`channel`),
  KEY `chat_notification_preferences_is_enabled_index` (`is_enabled`),
  KEY `chat_notification_preferences_muted_until_index` (`muted_until`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_pinned_conversations`
--

DROP TABLE IF EXISTS `chat_pinned_conversations`;
CREATE TABLE IF NOT EXISTS `chat_pinned_conversations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_pinned_conversation_user_unique` (`conversation_id`,`user_id`),
  KEY `chat_pinned_user_sort_idx` (`user_id`,`sort_order`),
  KEY `chat_pinned_conversations_user_id_index` (`user_id`),
  KEY `chat_pinned_conversations_created_by_index` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_recovery_access_logs`
--

DROP TABLE IF EXISTS `chat_recovery_access_logs`;
CREATE TABLE IF NOT EXISTS `chat_recovery_access_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recovery_request_id` bigint UNSIGNED NOT NULL,
  `accessed_by` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED DEFAULT NULL,
  `message_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_recovery_access_logs_uuid_unique` (`uuid`),
  KEY `chat_recovery_access_logs_message_id_foreign` (`message_id`),
  KEY `chat_recovery_access_request_created_idx` (`recovery_request_id`,`created_at`),
  KEY `chat_recovery_access_user_created_idx` (`accessed_by`,`created_at`),
  KEY `chat_recovery_access_conv_msg_idx` (`conversation_id`,`message_id`),
  KEY `chat_recovery_access_logs_accessed_by_index` (`accessed_by`),
  KEY `chat_recovery_access_logs_action_index` (`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_recovery_approvals`
--

DROP TABLE IF EXISTS `chat_recovery_approvals`;
CREATE TABLE IF NOT EXISTS `chat_recovery_approvals` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `recovery_request_id` bigint UNSIGNED NOT NULL,
  `approver_id` bigint UNSIGNED NOT NULL,
  `decision` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `decided_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_recovery_approval_request_decision_idx` (`recovery_request_id`,`decision`),
  KEY `chat_recovery_approval_approver_decided_idx` (`approver_id`,`decided_at`),
  KEY `chat_recovery_approvals_approver_id_index` (`approver_id`),
  KEY `chat_recovery_approvals_decision_index` (`decision`),
  KEY `chat_recovery_approvals_decided_at_index` (`decided_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_recovery_requests`
--

DROP TABLE IF EXISTS `chat_recovery_requests`;
CREATE TABLE IF NOT EXISTS `chat_recovery_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `conversation_id` bigint UNSIGNED DEFAULT NULL,
  `requested_by` bigint UNSIGNED NOT NULL,
  `reason_type` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_from` timestamp NULL DEFAULT NULL,
  `date_to` timestamp NULL DEFAULT NULL,
  `scope` json DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `request_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_recovery_requests_uuid_unique` (`uuid`),
  KEY `chat_recovery_org_status_idx` (`organization_id`,`status`),
  KEY `chat_recovery_requested_created_idx` (`requested_by`,`created_at`),
  KEY `chat_recovery_conv_range_idx` (`conversation_id`,`date_from`,`date_to`),
  KEY `chat_recovery_requests_organization_id_index` (`organization_id`),
  KEY `chat_recovery_requests_requested_by_index` (`requested_by`),
  KEY `chat_recovery_requests_reason_type_index` (`reason_type`),
  KEY `chat_recovery_requests_date_from_index` (`date_from`),
  KEY `chat_recovery_requests_date_to_index` (`date_to`),
  KEY `chat_recovery_requests_status_index` (`status`),
  KEY `chat_recovery_requests_expires_at_index` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_reports`
--

DROP TABLE IF EXISTS `chat_reports`;
CREATE TABLE IF NOT EXISTS `chat_reports` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `conversation_id` bigint UNSIGNED DEFAULT NULL,
  `message_id` bigint UNSIGNED DEFAULT NULL,
  `reported_by` bigint UNSIGNED NOT NULL,
  `reported_user_id` bigint UNSIGNED DEFAULT NULL,
  `reason_type` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_text` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `review_notes` text COLLATE utf8mb4_unicode_ci,
  `action_taken` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_reports_uuid_unique` (`uuid`),
  KEY `chat_reports_conversation_id_foreign` (`conversation_id`),
  KEY `chat_reports_org_status_idx` (`organization_id`,`status`),
  KEY `chat_reports_message_status_idx` (`message_id`,`status`),
  KEY `chat_reports_organization_id_index` (`organization_id`),
  KEY `chat_reports_reported_by_index` (`reported_by`),
  KEY `chat_reports_reported_user_id_index` (`reported_user_id`),
  KEY `chat_reports_reason_type_index` (`reason_type`),
  KEY `chat_reports_status_index` (`status`),
  KEY `chat_reports_reviewed_by_index` (`reviewed_by`),
  KEY `chat_reports_reviewed_at_index` (`reviewed_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_settings`
--

DROP TABLE IF EXISTS `chat_settings`;
CREATE TABLE IF NOT EXISTS `chat_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `setting_key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` json DEFAULT NULL,
  `data_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'json',
  `is_encrypted` tinyint(1) NOT NULL DEFAULT '0',
  `editable_by_admin` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_settings_uuid_unique` (`uuid`),
  UNIQUE KEY `chat_settings_org_key_unique` (`organization_id`,`setting_key`),
  KEY `chat_settings_key_editable_idx` (`setting_key`,`editable_by_admin`),
  KEY `chat_settings_organization_id_index` (`organization_id`),
  KEY `chat_settings_is_encrypted_index` (`is_encrypted`),
  KEY `chat_settings_editable_by_admin_index` (`editable_by_admin`),
  KEY `chat_settings_created_by_index` (`created_by`),
  KEY `chat_settings_updated_by_index` (`updated_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_user_devices`
--

DROP TABLE IF EXISTS `chat_user_devices`;
CREATE TABLE IF NOT EXISTS `chat_user_devices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `device_uuid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `device_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_token` text COLLATE utf8mb4_unicode_ci,
  `fcm_token` text COLLATE utf8mb4_unicode_ci,
  `public_identity_key` longtext COLLATE utf8mb4_unicode_ci,
  `public_prekey` longtext COLLATE utf8mb4_unicode_ci,
  `signed_prekey` longtext COLLATE utf8mb4_unicode_ci,
  `key_version` int UNSIGNED NOT NULL DEFAULT '1',
  `is_trusted` tinyint(1) NOT NULL DEFAULT '0',
  `last_active_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `revoked_by` bigint UNSIGNED DEFAULT NULL,
  `last_ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_devices_user_device_unique` (`user_id`,`device_uuid`),
  UNIQUE KEY `chat_user_devices_uuid_unique` (`uuid`),
  KEY `chat_devices_org_type_idx` (`organization_id`,`device_type`),
  KEY `chat_devices_user_revoked_idx` (`user_id`,`revoked_at`),
  KEY `chat_user_devices_organization_id_index` (`organization_id`),
  KEY `chat_user_devices_user_id_index` (`user_id`),
  KEY `chat_user_devices_device_type_index` (`device_type`),
  KEY `chat_user_devices_is_trusted_index` (`is_trusted`),
  KEY `chat_user_devices_last_active_at_index` (`last_active_at`),
  KEY `chat_user_devices_revoked_at_index` (`revoked_at`),
  KEY `chat_user_devices_revoked_by_index` (`revoked_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_user_presence`
--

DROP TABLE IF EXISTS `chat_user_presence`;
CREATE TABLE IF NOT EXISTS `chat_user_presence` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `device_uuid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'offline',
  `active_conversation_id` bigint UNSIGNED DEFAULT NULL,
  `socket_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_presence_user_device_unique` (`user_id`,`device_uuid`),
  KEY `chat_user_presence_active_conversation_id_foreign` (`active_conversation_id`),
  KEY `chat_presence_org_status_idx` (`organization_id`,`status`),
  KEY `chat_presence_status_expires_idx` (`status`,`expires_at`),
  KEY `chat_user_presence_organization_id_index` (`organization_id`),
  KEY `chat_user_presence_user_id_index` (`user_id`),
  KEY `chat_user_presence_device_uuid_index` (`device_uuid`),
  KEY `chat_user_presence_status_index` (`status`),
  KEY `chat_user_presence_socket_id_index` (`socket_id`),
  KEY `chat_user_presence_last_seen_at_index` (`last_seen_at`),
  KEY `chat_user_presence_expires_at_index` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_verification_tokens`
--

DROP TABLE IF EXISTS `email_verification_tokens`;
CREATE TABLE IF NOT EXISTS `email_verification_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_verification_tokens_token_unique` (`token`),
  KEY `email_verification_tokens_user_id_token_index` (`user_id`,`token`),
  KEY `email_verification_tokens_expires_at_index` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_histories`
--

DROP TABLE IF EXISTS `login_histories`;
CREATE TABLE IF NOT EXISTS `login_histories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `failure_reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `login_histories_user_id_logged_in_at_index` (`user_id`,`logged_in_at`),
  KEY `login_histories_email_index` (`email`),
  KEY `login_histories_status_index` (`status`),
  KEY `login_histories_ip_address_index` (`ip_address`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_histories`
--

INSERT INTO `login_histories` (`id`, `user_id`, `email`, `status`, `ip_address`, `user_agent`, `failure_reason`, `logged_in_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'test@example.com', 'failed', '127.0.0.1', 'curl/8.21.0', 'User not found', '2026-07-22 03:57:44', '2026-07-22 03:57:44', '2026-07-22 03:57:44'),
(2, 1, 'keely.mohr@yopmail.com', 'success', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '2026-07-22 10:45:51', '2026-07-22 10:45:51', '2026-07-22 10:45:51'),
(3, 1, 'keely.mohr@yopmail.com', 'success', '127.0.0.1', 'curl/8.14.1', NULL, '2026-07-22 11:03:51', '2026-07-22 11:03:51', '2026-07-22 11:03:51'),
(4, 1, 'keely.mohr@yopmail.com', 'success', '127.0.0.1', 'curl/8.14.1', NULL, '2026-07-22 11:14:01', '2026-07-22 11:14:01', '2026-07-22 11:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_08_000001_create_chat_conversations_table', 1),
(5, '2026_07_08_000002_create_chat_conversation_members_table', 1),
(6, '2026_07_08_000003_create_chat_messages_table', 1),
(7, '2026_07_08_000004_create_chat_message_attachments_table', 1),
(8, '2026_07_08_000005_create_chat_message_statuses_table', 1),
(9, '2026_07_08_000006_create_chat_user_presence_table', 1),
(10, '2026_07_08_000007_create_chat_user_devices_table', 1),
(11, '2026_07_08_000008_create_chat_muted_conversations_table', 1),
(12, '2026_07_08_000009_create_chat_pinned_conversations_table', 1),
(13, '2026_07_08_000010_create_chat_deleted_messages_table', 1),
(14, '2026_07_08_000011_create_chat_settings_table', 1),
(15, '2026_07_08_000012_create_chat_reports_table', 1),
(16, '2026_07_08_000013_create_chat_audit_logs_table', 1),
(17, '2026_07_08_000014_create_chat_encryption_keys_table', 1),
(18, '2026_07_08_000015_create_chat_message_key_recipients_table', 1),
(19, '2026_07_08_000016_create_chat_recovery_requests_table', 1),
(20, '2026_07_08_000017_create_chat_recovery_approvals_table', 1),
(21, '2026_07_08_000018_create_chat_recovery_access_logs_table', 1),
(22, '2026_07_08_000019_create_chat_notification_preferences_table', 1),
(23, '2026_07_08_000020_create_chat_notification_deliveries_table', 1),
(24, '2026_07_08_000021_create_chat_fcm_configurations_table', 1),
(25, '2026_07_22_000001_add_auth_fields_to_users_table', 1),
(26, '2026_07_22_000002_create_login_histories_table', 1),
(27, '2026_07_22_000003_create_account_lock_logs_table', 1),
(28, '2026_07_22_000004_create_email_verification_tokens_table', 1),
(29, '2026_07_22_000005_create_user_devices_table', 1),
(30, '2026_07_22_000006_create_two_factor_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('LQXbIZNMzetHIs2AoS7AOqhXBGFQi9KGGgNTkJNl', 1, '127.0.0.1', 'curl/8.14.1', 'eyJfdG9rZW4iOiJZOTZLZHhvWHhVM3MyYmZGUEFlY1Q0UjF0bkVuVFEyanJBYjBnOGR2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDk5XC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1784738641),
('H4OoKT55amkIF2qIo94STkpaeVaFTpaBXI3Et7b3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-IN) WindowsPowerShell/5.1.26100.8894', 'eyJfdG9rZW4iOiJ3MjhZWWU0MEtIemdBNFU4SmY1TkZIOHhraVZ0UjM1bzNibkx1cmhoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDk5XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1784738069),
('aGXiZFPEjkgFdVQyGYoWMKf546ndXTO6G0FFb7mJ', NULL, '127.0.0.1', 'curl/8.14.1', 'eyJfdG9rZW4iOiI4TmF6UFI5anBrbTM5MmkxMkZqcXhBWFlXMDZ6dU8xOXRxUFdkUU9GIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDk5XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1784738051),
('xBSds9YTFysJB2fAHBseZYPg6VeXTQQzjjcBk1kF', 1, '127.0.0.1', 'curl/8.14.1', 'eyJfdG9rZW4iOiJpNkFBdGhINzNXQXVKMk83Z2tsQ2VtOEtOSm0zeFZNck5ZRXhaeGRKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDk5XC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1784738031),
('L4y6dEex7gKpK9z7QcjX3R4uEKKDQggY7lkIF0vH', NULL, '127.0.0.1', 'curl/8.14.1', 'eyJfdG9rZW4iOiI0ck0wbTNQUThRWWd5TlgwNzRCZ254ZkROYjJ1SWNkNlg4OHBRM3lnIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDk5XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1784738003),
('EEuJ1w1kGfodnUgr4MoU4xyQNO7jP9qDtTVAHqvV', NULL, '127.0.0.1', 'curl/8.14.1', 'eyJfdG9rZW4iOiJBNmJ1aUFRT0lEbHlUZk16aTJjSXFrMEhPZjB5ZU9NWVVqR29vbVZxIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDk5XC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1784737992),
('Mn4j0J3IwsF8J76eQ4OMFygiubMMPmydTcZiUjpW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJoMnJlWk41QklnUURmNGdZcXZ6SGxnWkV5QlRtdDdEM0hocWN3bkZkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1784738437),
('K33oETW5k5SgFrPrZVPKqo6n5uqGCeJx5ZaQR1Xb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'eyJfdG9rZW4iOiJNRmpya0g1NkZVWFBWZTRhUVc0dG5hMm5WRGdlTFJWTkxPb0VaSGdWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1784737175),
('M1LJITuiCnWsNLCgMSmwY5jRLaLruxEkqsDqdbMG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.129.1 Chrome/148.0.7778.280 Electron/42.6.0 Safari/537.36', 'eyJfdG9rZW4iOiJlUW1zVDJDV2MwVnlPTFd4WmpMRXI4b0ZKdVpvalM1eHgyVFp1UFBoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1784735303);

-- --------------------------------------------------------

--
-- Table structure for table `two_factor_tokens`
--

DROP TABLE IF EXISTS `two_factor_tokens`;
CREATE TABLE IF NOT EXISTS `two_factor_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `two_factor_tokens_user_id_code_index` (`user_id`,`code`),
  KEY `two_factor_tokens_expires_at_index` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint UNSIGNED DEFAULT NULL,
  `employee_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_active_at` timestamp NULL DEFAULT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `failed_login_attempts` int UNSIGNED NOT NULL DEFAULT '0',
  `locked_until` timestamp NULL DEFAULT NULL,
  `mfa_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `mfa_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `theme` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'light',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_uuid_unique` (`uuid`),
  KEY `users_status_index` (`status`),
  KEY `users_locked_until_index` (`locked_until`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `organization_id`, `employee_id`, `name`, `first_name`, `last_name`, `email`, `phone`, `profile_photo_path`, `email_verified_at`, `password`, `remember_token`, `status`, `last_login_at`, `last_active_at`, `password_changed_at`, `failed_login_attempts`, `locked_until`, `mfa_enabled`, `mfa_type`, `timezone`, `locale`, `theme`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '8d36b83e-0808-41e3-86ee-eb811df533f1', NULL, NULL, 'Keely Mohr', 'Keely', 'Mohr', 'keely.mohr@yopmail.com', '9613032697', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'DZf4pbcQIv', 'active', '2026-07-22 11:14:01', '2026-07-22 11:14:01', NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 11:14:01'),
(2, '383a6fb2-7070-477f-a957-f28b46546715', NULL, NULL, 'Erin McCullough', 'Erin', 'McCullough', 'erin.mccullough@yopmail.com', '5677203935', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '1M1YNpiEa3', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(3, '0a1a2d46-ff12-4508-8db5-af8bcbad6703', NULL, NULL, 'Lilyan Bartell', 'Lilyan', 'Bartell', 'lilyan.bartell@yopmail.com', '5317728607', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'qyXZYett7W', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(4, 'cf6e447f-9e5e-4ae7-ba29-af788fe027b1', NULL, NULL, 'Sylvester Kovacek', 'Sylvester', 'Kovacek', 'sylvester.kovacek@yopmail.com', '4491125385', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'Wc87nPqzev', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(5, '4c09fafb-159a-4200-b71a-f37aa822179d', NULL, NULL, 'Fabian Kihn', 'Fabian', 'Kihn', 'fabian.kihn@yopmail.com', '2862377133', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ZJXhnh0j3I', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(6, '461cf751-9b7e-43fb-adae-80f9892b6da7', NULL, NULL, 'Shawn Vandervort', 'Shawn', 'Vandervort', 'shawn.vandervort@yopmail.com', '6733491248', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'XimpTDdTMM', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(7, 'b6a78969-e4a1-4f75-8e69-76ab685a0578', NULL, NULL, 'Lauren Fadel', 'Lauren', 'Fadel', 'lauren.fadel@yopmail.com', '3014354724', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ZpCd60mukP', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(8, 'fe479803-eecc-435a-8785-3694ea444cbb', NULL, NULL, 'Haylie Thiel', 'Haylie', 'Thiel', 'haylie.thiel@yopmail.com', '7776340399', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'h8zbr4YnlI', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(9, '2f38a8c6-2624-4a5b-b95f-08a38134be82', NULL, NULL, 'Wilmer Witting', 'Wilmer', 'Witting', 'wilmer.witting@yopmail.com', '4529308948', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'oyIeuBLTM9', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(10, 'ba78edbc-8105-4d93-ac7c-c85ef674a193', NULL, NULL, 'Hadley Hane', 'Hadley', 'Hane', 'hadley.hane@yopmail.com', '7831055957', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '1U8EmiVLJK', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(11, '8c6a7b7c-9f0b-48bf-bb26-2c9a9f91cf86', NULL, NULL, 'Theron Bernhard', 'Theron', 'Bernhard', 'theron.bernhard@yopmail.com', '4091762334', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'JZhxa3jvSQ', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(12, '1ebda0bb-80d6-40d4-8879-58670f4d5eae', NULL, NULL, 'Freeda Stehr', 'Freeda', 'Stehr', 'freeda.stehr@yopmail.com', '4461703776', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'nqg6uy78uq', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(13, '687834aa-1734-4065-a9eb-b808d49f225c', NULL, NULL, 'Efren Lockman', 'Efren', 'Lockman', 'efren.lockman@yopmail.com', '9129352790', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'i2ye0gzK4n', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(14, '85121dbc-f8e9-4eb4-8fe5-23e5ccccd597', NULL, NULL, 'Hyman Schumm', 'Hyman', 'Schumm', 'hyman.schumm@yopmail.com', '0943482324', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'F9KwS4oO8o', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(15, 'c1f87c6a-491a-4d96-b20c-0fb86021eca4', NULL, NULL, 'Myles Altenwerth', 'Myles', 'Altenwerth', 'myles.altenwerth@yopmail.com', '2741166193', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '5TkMurGGVu', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(16, 'e65766da-5755-4dbf-8764-f1a9187d1d35', NULL, NULL, 'Luigi Witting', 'Luigi', 'Witting', 'luigi.witting@yopmail.com', '1116808781', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'NBeiD77BYv', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(17, 'e7c3f095-0b92-4f11-b83b-18f4a1af417c', NULL, NULL, 'D\'angelo Kihn', 'D\'angelo', 'Kihn', 'dangelo.kihn@yopmail.com', '7203321193', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 't0R27C0ajU', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(18, '6dc4db38-36da-460e-8243-523eaaaa3e11', NULL, NULL, 'Tracy Nader', 'Tracy', 'Nader', 'tracy.nader@yopmail.com', '8897882164', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'xQtv0dC6Wk', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(19, 'f65a6080-558f-465f-868c-5bf22df6708f', NULL, NULL, 'Krystal Rolfson', 'Krystal', 'Rolfson', 'krystal.rolfson@yopmail.com', '7953393022', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'WpcbdaMRWZ', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(20, 'f65fbf4f-21be-4e42-a400-ec1b8196e6e8', NULL, NULL, 'Sylvan Block', 'Sylvan', 'Block', 'sylvan.block@yopmail.com', '4661048330', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'rtxGE2njXk', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(21, 'c9ee79b7-f161-46eb-8b8e-7cb676cf059e', NULL, NULL, 'Victor Homenick', 'Victor', 'Homenick', 'victor.homenick@yopmail.com', '2200152606', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'jxGuNcJGZc', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(22, '1ff2f87d-9f42-498d-aefc-234794ee8edb', NULL, NULL, 'Katharina Tillman', 'Katharina', 'Tillman', 'katharina.tillman@yopmail.com', '7824407225', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '5J8AE159Nz', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(23, 'c29e246f-a841-4260-8bb5-051521999790', NULL, NULL, 'Tessie Cartwright', 'Tessie', 'Cartwright', 'tessie.cartwright@yopmail.com', '6821185124', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'A5IVauvB1w', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(24, 'b2c94073-be8f-4ae9-a9e8-028dfcf99d3e', NULL, NULL, 'Paige Oberbrunner', 'Paige', 'Oberbrunner', 'paige.oberbrunner@yopmail.com', '0628075255', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'KhdmzQxjja', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(25, '69a99093-491a-4cbd-a9a4-dd6d69be5678', NULL, NULL, 'Brad Hudson', 'Brad', 'Hudson', 'brad.hudson@yopmail.com', '2374958580', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 's3pyD3aoNU', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(26, '11749752-e0e9-4ef2-a130-8e9f30c00eda', NULL, NULL, 'Lon Wintheiser', 'Lon', 'Wintheiser', 'lon.wintheiser@yopmail.com', '9764090809', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'QRzdUx3trQ', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(27, '30f7735f-d490-4944-b5df-4dd3f94d7672', NULL, NULL, 'Armani Larson', 'Armani', 'Larson', 'armani.larson@yopmail.com', '3583153513', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'iJthE9jUnn', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(28, 'cfd563d5-5069-489e-820c-650dda96236f', NULL, NULL, 'Jules O\'Conner', 'Jules', 'O\'Conner', 'jules.oconner@yopmail.com', '4579517972', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'y7OQUHlc7q', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(29, '50e05127-3f60-4e46-ba64-edc2c0f39863', NULL, NULL, 'Florine Hintz', 'Florine', 'Hintz', 'florine.hintz@yopmail.com', '7298732344', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'gWE5ucDWMn', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(30, 'fdff89dd-0426-4f05-be45-33759debc56a', NULL, NULL, 'Sebastian Dibbert', 'Sebastian', 'Dibbert', 'sebastian.dibbert@yopmail.com', '1735099035', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'Z4KyTfUmcj', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(31, 'de3d3662-ecfc-431a-a4eb-8c808aa855df', NULL, NULL, 'Rowan Lueilwitz', 'Rowan', 'Lueilwitz', 'rowan.lueilwitz@yopmail.com', '7085924456', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'S2B6QnjV0W', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(32, '1a156107-e388-4711-bf12-cb465bf2d15b', NULL, NULL, 'Elsa Hyatt', 'Elsa', 'Hyatt', 'elsa.hyatt@yopmail.com', '7176850655', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'nZBD3h310K', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(33, 'fa845445-d26e-48bb-aace-22f8bfad11fb', NULL, NULL, 'Jovan Turcotte', 'Jovan', 'Turcotte', 'jovan.turcotte@yopmail.com', '6158479422', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ut6h4wQvfz', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(34, '7b8bf90f-68a7-43bc-8a61-26730ba690d8', NULL, NULL, 'Floyd McCullough', 'Floyd', 'McCullough', 'floyd.mccullough@yopmail.com', '6012992178', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '5ZCviGPUKJ', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(35, 'b46a0fd7-7292-440d-96bc-20660a423cc5', NULL, NULL, 'Connor Lockman', 'Connor', 'Lockman', 'connor.lockman@yopmail.com', '7653929766', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'RHfKzUYjNf', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(36, '8638838f-1145-47ec-bf82-0f930270d738', NULL, NULL, 'Delphine Lakin', 'Delphine', 'Lakin', 'delphine.lakin@yopmail.com', '3867882736', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'OVHZQ7Kq4V', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(37, '46184720-2b19-42bf-816b-0e73228378c2', NULL, NULL, 'Eusebio Durgan', 'Eusebio', 'Durgan', 'eusebio.durgan@yopmail.com', '5839153538', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'GsgTOm0gby', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(38, '817557b1-de3a-45ca-a321-8f6e603d0bb6', NULL, NULL, 'Renee Oberbrunner', 'Renee', 'Oberbrunner', 'renee.oberbrunner@yopmail.com', '0048212894', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'euQIHSzR6W', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(39, '441999d9-1095-4e90-a328-bd7fa873875f', NULL, NULL, 'Gloria Weissnat', 'Gloria', 'Weissnat', 'gloria.weissnat@yopmail.com', '4560738885', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'y4at4Kj7JA', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(40, 'ed304c86-9b0d-4e99-b361-e988fc5c09f1', NULL, NULL, 'Camylle Schamberger', 'Camylle', 'Schamberger', 'camylle.schamberger@yopmail.com', '4236162868', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'UhbYuZhIwW', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(41, 'bbaaa72a-9294-4441-871b-fa3d87df8477', NULL, NULL, 'Zelda Lind', 'Zelda', 'Lind', 'zelda.lind@yopmail.com', '4117148308', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'g1NjrhTP1F', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(42, '99adb213-2d83-4182-95b3-becf720f2613', NULL, NULL, 'Gracie Bradtke', 'Gracie', 'Bradtke', 'gracie.bradtke@yopmail.com', '7279673671', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '5UIxshErFr', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(43, '34dd4615-b010-450f-8180-3b15f9023949', NULL, NULL, 'Lambert Brown', 'Lambert', 'Brown', 'lambert.brown@yopmail.com', '9645885246', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'U7LsxITp7Q', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(44, '7b5dcc20-ca2e-4c83-acf7-51b4c3b64bd1', NULL, NULL, 'Candice Herzog', 'Candice', 'Herzog', 'candice.herzog@yopmail.com', '4442643533', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'oCvJKP78LS', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(45, 'a63a6145-597f-4b25-aa82-afa1b44d5c56', NULL, NULL, 'Rowena Moen', 'Rowena', 'Moen', 'rowena.moen@yopmail.com', '0000452852', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '1Nn8EFHTTB', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(46, '98a0d1a7-eb72-43a7-bed5-136b799bdc7f', NULL, NULL, 'Haleigh Cummings', 'Haleigh', 'Cummings', 'haleigh.cummings@yopmail.com', '1666616419', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '4bjc2Re2Ji', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(47, '90cd85de-c1f7-414a-ba64-a0b5c8d830e2', NULL, NULL, 'Neoma Prosacco', 'Neoma', 'Prosacco', 'neoma.prosacco@yopmail.com', '9729021768', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'XCTNJj6Ic3', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(48, '3742813f-9f8b-436e-b1c3-c32e939b1c29', NULL, NULL, 'Russel Bailey', 'Russel', 'Bailey', 'russel.bailey@yopmail.com', '9750253768', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ZOvA5zan74', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(49, 'f37beafa-0d4f-40b4-9fb5-0eb749c1cfbe', NULL, NULL, 'Doris Anderson', 'Doris', 'Anderson', 'doris.anderson@yopmail.com', '7018340172', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'DnoEep2LO3', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(50, 'd12c0aaa-1a6e-4e02-ab13-edb50e450681', NULL, NULL, 'Lennie Kovacek', 'Lennie', 'Kovacek', 'lennie.kovacek@yopmail.com', '8422498445', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'pNCkFO47L3', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(51, 'f177b869-80bf-4c90-a89f-e990448b8181', NULL, NULL, 'Carmine Hagenes', 'Carmine', 'Hagenes', 'carmine.hagenes@yopmail.com', '0189832837', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'MCwZQIq6gQ', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(52, '72040182-b16b-401b-83f0-1950104be610', NULL, NULL, 'Alba Pfeffer', 'Alba', 'Pfeffer', 'alba.pfeffer@yopmail.com', '0824665371', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'gS3jSjS06U', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(53, 'cc8d3e25-4217-412c-8760-48c33767092a', NULL, NULL, 'Oma Nicolas', 'Oma', 'Nicolas', 'oma.nicolas@yopmail.com', '7153459187', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'TfedLKBddj', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(54, '26fe8d2e-60e2-427d-bb38-c93181ba79ee', NULL, NULL, 'Wilfred Gleason', 'Wilfred', 'Gleason', 'wilfred.gleason@yopmail.com', '1939326685', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'efVYb4m37S', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(55, '60b81852-32fb-40da-90e0-250b1bf2a933', NULL, NULL, 'Mac Grant', 'Mac', 'Grant', 'mac.grant@yopmail.com', '5602543956', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'Io8GYgDbgL', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(56, '37177338-de2f-4a5e-9576-8d6f1720e283', NULL, NULL, 'Maryjane Hayes', 'Maryjane', 'Hayes', 'maryjane.hayes@yopmail.com', '4465131215', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ss6uaU66gh', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(57, '63b3ca58-3bf8-4a34-a820-2c9dab6a7a3f', NULL, NULL, 'Rozella Grady', 'Rozella', 'Grady', 'rozella.grady@yopmail.com', '6904217014', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ynV3upoA3e', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(58, '5d93041d-308b-4b4c-bfdd-b7d7b6c16551', NULL, NULL, 'Andres Cartwright', 'Andres', 'Cartwright', 'andres.cartwright@yopmail.com', '9897405867', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '8wSUBPZ1n1', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(59, '6e4434f9-2bdd-4774-906e-1170733162bf', NULL, NULL, 'Willy Carroll', 'Willy', 'Carroll', 'willy.carroll@yopmail.com', '4101165145', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'nnEtDeKTc8', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(60, '9da315cf-58e2-44c6-80c0-08b98f031a76', NULL, NULL, 'Aliyah Kutch', 'Aliyah', 'Kutch', 'aliyah.kutch@yopmail.com', '4986874307', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'mb3d0NcnRW', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(61, 'd1eabb00-ff1b-470e-b23c-bac0a9ee82b2', NULL, NULL, 'Boyd Stanton', 'Boyd', 'Stanton', 'boyd.stanton@yopmail.com', '1315892005', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'K29pC0bYo9', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(62, '1fcbdd86-cf38-4b17-99c8-8d25b70783a5', NULL, NULL, 'Yasmin Stehr', 'Yasmin', 'Stehr', 'yasmin.stehr@yopmail.com', '1202863370', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'VyY8XhcpRD', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(63, '67a4ddf4-c93e-409d-9553-3f798c6386b2', NULL, NULL, 'Rosalinda Rath', 'Rosalinda', 'Rath', 'rosalinda.rath@yopmail.com', '2801451978', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '1jksNouk39', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(64, '2ad5e36a-3840-4185-bb7a-c2b139e3ee05', NULL, NULL, 'Odie Hane', 'Odie', 'Hane', 'odie.hane@yopmail.com', '7785961660', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'njCFfYd0Uu', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(65, '43f78bb7-483a-415e-99be-c673ffee4a61', NULL, NULL, 'Ian Turner', 'Ian', 'Turner', 'ian.turner@yopmail.com', '0469065693', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'A5KrJJqK9e', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(66, '566b6c08-020c-47b9-8454-847798465471', NULL, NULL, 'Alvina Conn', 'Alvina', 'Conn', 'alvina.conn@yopmail.com', '9017126763', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'W4RE5drws8', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(67, 'cceaf019-a6b6-40b1-9cc4-1686a89d4356', NULL, NULL, 'Agustina Ryan', 'Agustina', 'Ryan', 'agustina.ryan@yopmail.com', '1135526474', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '9ZbaZPsERB', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(68, 'a3742305-8476-458e-be34-9ea7f33fca8f', NULL, NULL, 'Ima Olson', 'Ima', 'Olson', 'ima.olson@yopmail.com', '6336468853', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'gSuPdRvdHO', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(69, '9d31fd62-7f9c-4549-8c4a-fe36361aa951', NULL, NULL, 'Royal Muller', 'Royal', 'Muller', 'royal.muller@yopmail.com', '1823558834', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ESxCrmq9Pu', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(70, '56241a2d-0dc6-4fda-876f-70a02a80d992', NULL, NULL, 'Wilbert Jacobson', 'Wilbert', 'Jacobson', 'wilbert.jacobson@yopmail.com', '0172755554', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '6z4GLqyBtp', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(71, '6fdc2d6c-b71a-49a1-8b90-e18110bbed0c', NULL, NULL, 'Demetrius Lubowitz', 'Demetrius', 'Lubowitz', 'demetrius.lubowitz@yopmail.com', '7827813587', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '4mXi4fo3OX', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(72, '908e081c-1c5a-48f3-b124-eb5d936bbcd2', NULL, NULL, 'Brody Kuhlman', 'Brody', 'Kuhlman', 'brody.kuhlman@yopmail.com', '5874121447', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'G10QvOy1vq', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(73, 'd981ade5-a518-468e-bbd4-a8c679fe63d7', NULL, NULL, 'Savannah Bernhard', 'Savannah', 'Bernhard', 'savannah.bernhard@yopmail.com', '7879151209', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'tyzyAeEmUm', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(74, '70a349b4-8702-4eac-8d46-c21d4ef71d22', NULL, NULL, 'Ewell Abernathy', 'Ewell', 'Abernathy', 'ewell.abernathy@yopmail.com', '1058966164', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'EbpB2yen8Z', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(75, '8888fb71-cbd8-499d-a307-04da557d08c3', NULL, NULL, 'Rosa Gaylord', 'Rosa', 'Gaylord', 'rosa.gaylord@yopmail.com', '7002602299', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'xk9SOxS3Fc', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(76, '15adc1a4-7321-4f5a-a69a-b061b2647b24', NULL, NULL, 'Gene Kohler', 'Gene', 'Kohler', 'gene.kohler@yopmail.com', '3296260450', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'dUFB6nzPEN', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(77, '78425752-d2c7-4461-9cbe-7e2bd905c4ca', NULL, NULL, 'Dominic Berge', 'Dominic', 'Berge', 'dominic.berge@yopmail.com', '3227331621', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'BtoEdLDokC', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(78, '0fe3692f-93ca-4b31-8cbf-118c646c761a', NULL, NULL, 'Jermaine Mueller', 'Jermaine', 'Mueller', 'jermaine.mueller@yopmail.com', '4789239426', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'nf0CYvv3DN', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(79, 'fba93eff-5acf-432a-a1b1-628a84501e7e', NULL, NULL, 'Raegan Huels', 'Raegan', 'Huels', 'raegan.huels@yopmail.com', '8806457115', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'EMAK3kDhEt', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(80, 'ed0ab34c-0be8-47ed-9421-917dfb71d0fe', NULL, NULL, 'Florine Orn', 'Florine', 'Orn', 'florine.orn@yopmail.com', '7775502178', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'gsURvndJ2e', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(81, '2a5016d9-2b04-495e-80c2-8048a715ce3e', NULL, NULL, 'Jonathon Abshire', 'Jonathon', 'Abshire', 'jonathon.abshire@yopmail.com', '6954665577', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'Jsf28oYkFS', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(82, '8a93b4ee-eba9-4d9c-a913-46ea2604349c', NULL, NULL, 'Abigail Goodwin', 'Abigail', 'Goodwin', 'abigail.goodwin@yopmail.com', '4496113915', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'cRIrZyyb2A', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(83, '316141e2-30ef-4104-b848-fdb32e61f835', NULL, NULL, 'Sonia Bogisich', 'Sonia', 'Bogisich', 'sonia.bogisich@yopmail.com', '8052028529', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'Z6qK1p0BlS', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(84, '85bcf3e4-f4d5-490c-90a9-f056be97d254', NULL, NULL, 'Dalton Spencer', 'Dalton', 'Spencer', 'dalton.spencer@yopmail.com', '2593543817', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '97FNhyViUu', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(85, '28598bdd-157d-4bdc-b308-51aed5b510ff', NULL, NULL, 'Veda Orn', 'Veda', 'Orn', 'veda.orn@yopmail.com', '9723003179', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'CDkAYNV5Ti', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(86, '396ac248-a05c-4a25-92cc-4255d0bc1207', NULL, NULL, 'Nyah Moen', 'Nyah', 'Moen', 'nyah.moen@yopmail.com', '0249724124', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'Csr2GvacqF', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(87, '264e4ac1-8715-4dc4-a557-549b17fd3086', NULL, NULL, 'Thalia Weissnat', 'Thalia', 'Weissnat', 'thalia.weissnat@yopmail.com', '2976942004', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'AmadvrGbTe', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(88, '3b892294-827a-4b86-b525-2105cccaafa2', NULL, NULL, 'Adeline Turner', 'Adeline', 'Turner', 'adeline.turner@yopmail.com', '7418335933', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '32uCSXnVqO', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(89, '72df2daf-f23a-4af3-9411-e935ad7c978e', NULL, NULL, 'Jonathon Quitzon', 'Jonathon', 'Quitzon', 'jonathon.quitzon@yopmail.com', '2694550013', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'v7rOZewX2L', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(90, '4e5b027f-afd3-474e-8830-a6f28546b564', NULL, NULL, 'Arvid Jacobson', 'Arvid', 'Jacobson', 'arvid.jacobson@yopmail.com', '2014809207', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '7h17gPMdlL', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(91, 'eadfdacd-37d9-4571-99cf-c0b416b28aac', NULL, NULL, 'Ludie Brown', 'Ludie', 'Brown', 'ludie.brown@yopmail.com', '8130464140', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'U9ep9OaLQu', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(92, '88518cde-42fe-4030-ad62-b11da1a55128', NULL, NULL, 'Jordi Farrell', 'Jordi', 'Farrell', 'jordi.farrell@yopmail.com', '0821101282', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'g7t0ZBWKLJ', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(93, '0891a41a-a85c-49be-a3a1-96fb3078519a', NULL, NULL, 'Ludie Gusikowski', 'Ludie', 'Gusikowski', 'ludie.gusikowski@yopmail.com', '8655745713', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'ycmhtlqDbY', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(94, '8dc42490-7c68-4afd-a75d-b3449a601d77', NULL, NULL, 'Boris Ryan', 'Boris', 'Ryan', 'boris.ryan@yopmail.com', '8176854239', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', '50ge6cFpYH', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(95, '68b53fd1-34f9-4a0c-8288-d8feaf6e1c00', NULL, NULL, 'Mayra Ortiz', 'Mayra', 'Ortiz', 'mayra.ortiz@yopmail.com', '4417677157', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'T8UncxlbuM', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(96, '40b0794b-68f5-48fd-92d2-704d60889be0', NULL, NULL, 'Maurine Lowe', 'Maurine', 'Lowe', 'maurine.lowe@yopmail.com', '2880423771', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'k3scmfAMPm', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(97, 'c5025f78-322d-4849-9af3-0a349baaf29a', NULL, NULL, 'Hallie Ankunding', 'Hallie', 'Ankunding', 'hallie.ankunding@yopmail.com', '4641279482', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'aq4J75GwtR', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(98, 'fc8be994-7246-48e3-b767-aa8223613607', NULL, NULL, 'Jewell Rau', 'Jewell', 'Rau', 'jewell.rau@yopmail.com', '1202088289', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'WebtK5Mma3', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(99, 'c0f73c87-1b2b-488d-a9b3-11b0e1c764c6', NULL, NULL, 'Lenna Marquardt', 'Lenna', 'Marquardt', 'lenna.marquardt@yopmail.com', '8560016732', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'g0EMooCrY0', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49'),
(100, 'a1c59315-ff95-4f75-9a03-158cfbdd7d73', NULL, NULL, 'Rosalind Dietrich', 'Rosalind', 'Dietrich', 'rosalind.dietrich@yopmail.com', '1231646758', NULL, '2026-07-22 10:33:49', '$2y$12$eodEcrLFUT1iJR0UX9PF8eLHF6xw.H2rRYRVXB8fu7JuAGq.t0BIS', 'fsTEFuabrJ', 'active', NULL, NULL, NULL, 0, NULL, 0, NULL, 'UTC', 'en', 'light', NULL, NULL, NULL, NULL, '2026-07-22 10:33:49', '2026-07-22 10:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

DROP TABLE IF EXISTS `user_devices`;
CREATE TABLE IF NOT EXISTS `user_devices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_active_at` timestamp NULL DEFAULT NULL,
  `trusted_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_devices_user_id_device_id_index` (`user_id`,`device_id`),
  KEY `user_devices_ip_address_index` (`ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
