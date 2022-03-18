<template>
    <div class="modal fade modalbox" id="termsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <slot name="header">
                        <h5 class="modal-title">{{$trans('strings.Terms of the agreement')}}</h5>
                    </slot>
                    <a href="javascript:;" data-bs-dismiss="modal">{{$trans('strings.Close')}}</a>
                </div>
                <div class="modal-body">
                    <slot name="body">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fermentum, urna eget finibus
                            fermentum, velit metus maximus erat, nec sodales elit justo vitae sapien. Sed fermentum
                            varius erat, et dictum lorem. Cras pulvinar vestibulum purus sed hendrerit. Praesent et
                            auctor dolor. Ut sed ultrices justo. Fusce tortor erat, scelerisque sit amet diam rhoncus,
                            cursus dictum lorem. Ut vitae arcu egestas, congue nulla at, gravida purus.
                        </p>
                        <p>
                            Donec in justo urna. Fusce pretium quam sed viverra blandit. Vivamus a facilisis lectus.
                            Nunc non aliquet nulla. Aenean arcu metus, dictum tincidunt lacinia quis, efficitur vitae
                            dui. Integer id nisi sit amet leo rutrum placerat in ac tortor. Duis sed fermentum mi, ut
                            vulputate ligula.
                        </p>
                        <p>
                            Vivamus eget sodales elit, cursus scelerisque leo. Suspendisse lorem leo, sollicitudin
                            egestas interdum sit amet, sollicitudin tristique ex. Class aptent taciti sociosqu ad litora
                            torquent per conubia nostra, per inceptos himenaeos. Phasellus id ultricies eros. Praesent
                            vulputate interdum dapibus. Duis varius faucibus metus, eget sagittis purus consectetur in.
                            Praesent fringilla tristique sapien, et maximus tellus dapibus a. Quisque nec magna dapibus
                            sapien iaculis consectetur. Fusce in vehicula arcu. Aliquam erat volutpat. Class aptent
                            taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                        </p>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "InformModal",
}
</script>
