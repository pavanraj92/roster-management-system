# Bug Resolution Report - March 24, 2026

Below is the list of bugs and improvements addressed today in the Roster Management System.

| ID | Module | Bug Description | Status | Resolution / Fix Details |
|:---|:---|:---|:---|:---|
| B001 | Authentication | Password Toggle & Validation Icon Overlap | ✅ Fixed | Adjusted icon spacing (`me-5`) and container structure to prevent overlap with Bootstrap validation icons. |
| B002 | Profile | "Confirm Password" eye icon alignment | ✅ Fixed | Standardized HTML structure in [profile/index.blade.php](file:///d:/laragon/www/roster-management-system/resources/views/admin/profile/index.blade.php) to ensure consistent icon placement. |
| B003 | Security | Weak Password Validation Rules | ✅ Updated | Implemented strict regex (Uppercase, Lowercase, Number, Special Char) and 8-char minimum across all entry points. |
| B004 | Authentication | Vague Validation Messages | ✅ Improved | Added custom, user-friendly error messages specifically for each validation rule in Request files. |
| B005 | Roster | Missing AJAX Validation in Modals | ✅ Fixed | Added logic to [roster.js](file:///d:/laragon/www/roster-management-system/public/backend/js/pages/roster.js) to catch 422 errors and display specific validation feedback inside 'Assign' and 'Edit' modals. |
| B006 | Roster | Unsuccessful Shift Assignments | ✅ Improved | Added SweetAlert2 notifications for successful assignments and updates instead of silent refreshes. |
| B007 | Tasks | Task Description Layout | ✅ Tweaked | Expanded task description textarea size for better readability and editing experience. |
| B008 | UI | Global Form Field Outlines | ✅ Polished | Ensured `is-invalid` classes correctly trigger red borders and standardized validation feedback. |

## Documentation Summary
- **Files Modified:**
    - [resources/views/admin/profile/index.blade.php](file:///d:/laragon/www/roster-management-system/resources/views/admin/profile/index.blade.php)
    - [resources/views/admin/auth/login.blade.php](file:///d:/laragon/www/roster-management-system/resources/views/admin/auth/login.blade.php)
    - [public/backend/js/pages/roster.js](file:///d:/laragon/www/roster-management-system/public/backend/js/pages/roster.js)
    - [app/Http/Requests/Profile/PasswordUpdateRequest.php](file:///d:/laragon/www/roster-management-system/app/Http/Requests/Profile/PasswordUpdateRequest.php)
    - [app/Http/Requests/Auth/RegisterRequest.php](file:///d:/laragon/www/roster-management-system/app/Http/Requests/Auth/RegisterRequest.php)
    - [app/Http/Requests/Auth/ResetPasswordRequest.php](file:///d:/laragon/www/roster-management-system/app/Http/Requests/Auth/ResetPasswordRequest.php)
    - [resources/views/admin/tasks/form.blade.php](file:///d:/laragon/www/roster-management-system/resources/views/admin/tasks/form.blade.php)

> [!TIP]
> You can copy this table directly into Excel or Google Sheets by highlighting the rows and pasting. Both tools will recognize the markdown table format automatically.
