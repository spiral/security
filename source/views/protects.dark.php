<?php
/**
 * @var \Spiral\Guard\GuardInterface $guard
 */
$guard = $this->container->get(\Spiral\Guard\GuardInterface::class);

/*
 * Todo: Fetch context from attributes
 *
 * Ideal:
 * <guard:protects name="post.edit" post="<?= $post ?>">
 *      something
 * </guard:protects>
 */
if ($guard->allows('${permission}${id}${name}${p}')) { ?>${context}<?php } ?>
