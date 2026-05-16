import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
export const download = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/mon-inscription/{reference}/{type}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
download.url = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    reference: args[0],
                    type: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        reference: args.reference,
                                type: args.type,
                }

    return download.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace('{type}', parsedArgs.type.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
download.get = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
download.head = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
    const downloadForm = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: download.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
        downloadForm.get = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: download.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
        downloadForm.head = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: download.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    download.form = downloadForm
const participant = {
    download: Object.assign(download, download),
}

export default participant