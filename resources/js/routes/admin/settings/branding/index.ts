import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\SettingsController::update
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/settings/branding',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::update
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::update
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::update
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
    const updateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::update
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
        updateForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
/**
* @see \App\Http\Controllers\Admin\SettingsController::preset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
export const preset = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: preset.url(options),
    method: 'post',
})

preset.definition = {
    methods: ["post"],
    url: '/admin/settings/branding/apply-preset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::preset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
preset.url = (options?: RouteQueryOptions) => {
    return preset.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::preset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
preset.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: preset.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::preset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
    const presetForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: preset.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::preset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
        presetForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: preset.url(options),
            method: 'post',
        })
    
    preset.form = presetForm
const branding = {
    update: Object.assign(update, update),
preset: Object.assign(preset, preset),
}

export default branding