# Cognix cache bundle by CWS

## Configuration

**Add this line on bundles.php:**

```
Cws\Bundle\CognixCacheBundle\CwsCognixCacheCacheBundle::class => ['all' => true],
```

Create `cws_cognix_cache.yaml` into config/packages:
```
cws_cognix_cache:
    uri: 'my uri'
```

It's done.
