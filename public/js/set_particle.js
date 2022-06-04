window.addEventListener('DOMContentLoaded', function () {
    $('.particles-bg').each(function () {
        const $self = $(this);
        const $self_id = $self.attr('id');
        const _pt_base = ($self.data('pt-base')) ? $self.data('pt-base') : '#fff';
        const _pt_base_op = ($self.data('pt-base-op')) ? parseFloat($self.data('pt-base-op')) : 0.10;
        const _pt_shape = ($self.data('pt-shape')) ? $self.data('pt-shape') : '#fff';
        const _pt_shape_op = ($self.data('pt-shape-op')) ? parseFloat($self.data('pt-shape-op')) : 0.10;
        const _pt_line = ($self.data('pt-line')) ? $self.data('pt-line') : '#fff';
        const _pt_line_op = ($self.data('pt-line-op')) ? parseFloat($self.data('pt-line-op')) : 0.20;

        particlesJS($self_id, {
            "particles": {
                "number": {
                    "value": 100,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": _pt_base,
                },
                "shape": {
                    "type": "circle",
                    "opacity": _pt_shape_op,
                    "stroke": {
                        "width": 0,
                        "color": _pt_shape,
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": _pt_base_op,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.12,
                        "sync": false
                    }
                },
                "size": {
                    "value": 6,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.08,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": _pt_line,
                    "opacity": _pt_line_op,
                    "width": 1.3
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": false,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 6
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    });
});
