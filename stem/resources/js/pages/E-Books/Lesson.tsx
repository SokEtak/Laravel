import type { PageProps } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/react';

export default function Lesson() {
    const { props } = usePage<PageProps<{ subject?: string; program?: string; grade?: string }>>();
    const { subject = 'Unknown Subject', program = 'Unknown Program', grade = 'Unknown Grade' } = props;

    // Normalize subject to lowercase and remove spaces
    const normalizedSubject = subject.toLowerCase().replace(/\s+/g, '');

    // Define the grades object with grade -> program -> subject -> { pdf, flipbook, aiTools }
    const grades: { [key: string]: { [key: string]: { [key: string]: { pdf?: string; flipbook: string; aiTools?: { url: string; name?: string }[] } } } } = {
        "1": {
            "cambodia": {
                "math": { pdf: "1GtH_b64YxegOsW0dbak0ot7cwLxGnYfE", flipbook: "https://online.fliphtml5.com/ayjcf/xlcl/" },
                "science": { pdf: "1AKoB1TggCdjtj4JrwSzvKgmhpFCUNYTB", flipbook: "#" },
                "social": { pdf: "1SL0FWWCViBvQBz8lvnvHP_olw9zGk5l6", flipbook: "https://online.fliphtml5.com/ayjcf/jgfb/" },
                "khmer": { pdf: "1i2MGyGWPQwupjLDNCruRJmjS-VoikuKd", flipbook: "https://online.fliphtml5.com/ayjcf/wruc/" },
                "virtual-lab": { pdf: "#", flipbook: "https://phet.colorado.edu/en/simulations/filter?subjects=physics&type=html" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" }
            }
        },
        "2": {
            "cambodia": {
                "math": { pdf: "1AarunHQniUFrdyDEEYecND_LXo6FA4zH", flipbook: "https://online.fliphtml5.com/frszu/beag/" },
                "science": { pdf: "14PAVUeQyYmv8JdnS5yzcZeDdAfeYh_pl", flipbook: "https://online.fliphtml5.com/yhbke/egju/" },
                "social": { pdf: "1bO39VjJXE7P-WO7ovBUKKA69rY9mbKmW", flipbook: "https://online.fliphtml5.com/ayjcf/mdui/" },
                "khmer": { pdf: "1bc89FmtR2fSE8_oM1GbNfcFAuvlTD3hw", flipbook: "https://online.fliphtml5.com/ayjcf/wuqh/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" }
            }
        },
        "3": {
            "cambodia": {
                "math": { pdf: "14_I5gclFkQCE3adTnpMc3eNFmOgYaeEx", flipbook: "https://online.fliphtml5.com/frszu/mlxm/" },
                "science": { pdf: "1KHvzDUCykCco5lIYnTiY71892vtnUJ3g", flipbook: "https://online.fliphtml5.com/ayjcf/mdui/" },
                "social": { pdf: "1H762S5l6ZlJwSDKUY-FWX6ZlVTjqEJih", flipbook: "https://online.fliphtml5.com/ayjcf/mdui/" },
                "reading": { pdf: "1IUf3VFO2eubJf2UPp-WxznHSA3Dfqokb", flipbook: "#" },
                "khmer": { pdf: "1BaL5b2UDaWww1rFlCHMFj-hO6M_5c-Tf", flipbook: "https://online.fliphtml5.com/frszu/pesv/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" },
                "reading": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" }
            }
        },
        "4": {
            "cambodia": {
                "chaching": { pdf: "18s612_lwpCq7rRnWnHXJxdEmM7iUtTwo", flipbook: "https://online.fliphtml5.com/yhbke/wdok/" },
                "math": { pdf: "1XYND_ahzAg8bXXaKscAnUbJklxy7w-qM", flipbook: "https://online.fliphtml5.com/ayjcf/xjbv/" },
                "history": { pdf: "1m03_gTMECeMCVexcD0xQw3WjUDzS0jbe", flipbook: "https://online.fliphtml5.com/ayjcf/bicw/" },
                "khmer": { pdf: "13S4xJ8GVfYvB8gDxnlq5x3co1iPACxBT", flipbook: "https://online.fliphtml5.com/ayjcf/jwms/" },
                "english": { pdf: "1PF3x2ycB6vFkUzM0s8AFhkfRRUi6TKd7", flipbook: "https://online.fliphtml5.com/ayjcf/bicw/" },
                "science": { pdf: "1QhObR3ZFSr-JN6LfvAP-bacb8ds-s5Io", flipbook: "https://online.fliphtml5.com/ayjcf/gwqs/" },
                "social": { pdf: "1_hJWsTgM4O8Q9gFU_0oL7AkkiMrnlwHO", flipbook: "https://online.fliphtml5.com/frszu/ptwp/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "chaching": { pdf: "#", flipbook: "#" },
                "math": { pdf: "#", flipbook: "#" },
                "history": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" }
            }
        },
        "5": {
            "cambodia": {
                "math": { pdf: "1TmN7W2dcLpwrTHuZAuQnk4A8mgBQpi8l", flipbook: "https://online.fliphtml5.com/frszu/bjtb/" },
                "khmer": { pdf: "1gZTxkP2ciOQ6RmJoN541VMS0kPD6_qLp", flipbook: "https://online.fliphtml5.com/yhbke/rgyk/" },
                "english": { pdf: "1SYRUilVE2xW8Z_4MIxMLyaCL8GnmsLOJ", flipbook: "https://online.fliphtml5.com/yhbke/wdiv/" },
                "science": { pdf: "1qpRXBqmz9YvLpO5xJj1y5aUI4hIQzfH5", flipbook: "https://online.fliphtml5.com/yhbke/cxop/" },
                "social": { pdf: "1gt8sqHQ9tgGIKyGnL4Hc-xHrkhpUsTYs", flipbook: "https://online.fliphtml5.com/yhbke/qlef/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" }
            }
        },
        "6": {
            "cambodia": {
                "math": { pdf: "1Z8mFgA4a3hvU9e-MYgnJ_M_Y_8Gh-C7U", flipbook: "https://online.fliphtml5.com/frszu/mder/" },
                "history": { pdf: "14IWWmfqNSSIBpp9I8jzMgIzc6MEqx-xv", flipbook: "https://online.fliphtml5.com/frszu/yldb/" },
                "khmer": { pdf: "1NMAONAHIMCL-zQX3pz2tt2BqMn2CQPs1", flipbook: "https://online.fliphtml5.com/frszu/umpk/" },
                "english": { pdf: "1-KbBGLLQzsz1VBXSucTePh7UfGUoi3wN", flipbook: "https://online.fliphtml5.com/frszu/gozi/" },
                "science": { pdf: "1VbJoyCa-H0SNA3hstyPcPQWfszh5jNp9", flipbook: "https://online.fliphtml5.com/yhbke/ckvl/" },
                "social": { pdf: "1N9nLoo5aLzZ3tPP_trwBKRDX3YpOF_wl", flipbook: "https://online.fliphtml5.com/yhbke/ffmk/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "history": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" }
            }
        },
        "7": {
            "cambodia": {
                "math": { pdf: "1I_H7gOzD2HhMA0XIjx2WCVJMUSeZPI6b", flipbook: "#" },//larger file
                "khmer": { pdf: "1EikPEwmG9uniJ-NSOr6WMC3N_COJ7D9C", flipbook: "https://online.fliphtml5.com/yhbke/zrju/" },
                "english": { pdf: "1V9hnZcPSc1Y0oOnJcEwDYi5AKhSw_1wO", flipbook: "https://online.fliphtml5.com/yhbke/zyuq/" },
                "science": { pdf: "1Z6Ot0z3brZ8QWz9Dnzxo4MOT3Manixp8", flipbook: "https://online.fliphtml5.com/yhbke/edes/" },
                "social": { pdf: "1b7ie5S-IykSCbXpx4H67VuQ0P31h_KUV", flipbook: "https://online.fliphtml5.com/apzgt/xglk/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" }
            }
        },
        "8": {
            "cambodia": {
                "math": { pdf: "1_RUcBu5lITC_LGWG4BTdVJRTCx-vKmvQ", flipbook: "" },//larger file
                "khmer": { pdf: "117cgoDQ3kEmN6J-2oY2OXL6ZrG7wFwnl", flipbook: "https://online.fliphtml5.com/apzgt/fink/" },
                "english": { pdf: "1wVK84yVqYnZfpayouwi_AWxj8VlVBtzh", flipbook: "https://online.fliphtml5.com/apzgt/cssh/" },
                "science": { pdf: "1jVmXAXEjquYWrnV9E2TY7--qLToL7gtz", flipbook: "https://online.fliphtml5.com/apzgt/lirg/" },
                "social": { pdf: "1v3ez-eLprH2KJArYqv3hkzJRGq9kx6MR", flipbook: "https://online.fliphtml5.com/apzgt/pjqz/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" }
            }
        },
        "9": {
            "cambodia": {
                "math": { pdf: "1ocymmBiv7X6DdmXk6yZczobLs9NDo_oD", flipbook: "https://online.fliphtml5.com/frszu/dpgo/" },
                "khmer": { pdf: "1sed5sZKo0V17G6UJko3uUZ7k41b7yT_D", flipbook: "https://online.fliphtml5.com/ecumu/usjo/" },
                "english": { pdf: "15cVajVp6-Y7vY5wcsUCGx8OHee3sM68B", flipbook: "https://online.fliphtml5.com/frszu/aiik/" },
                "science": { pdf: "1CQfDPPvd-pR_0CQCzb1Ycf5r7sW8F1po", flipbook: "https://online.fliphtml5.com/ecumu/ixrn/" },
                "social": { pdf: "1499jKWdcYWYF3p0e9M3O56YKI4o0t9x1", flipbook: "https://online.fliphtml5.com/ecumu/ygfz/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "science": { pdf: "#", flipbook: "#" },
                "social": { pdf: "#", flipbook: "#" }
            }
        },
        "10": {
            "cambodia": {
                "math": { pdf: "#", flipbook: "#" },
                "history": { pdf: "#", flipbook: "#" },
                "geography": { pdf: "#", flipbook: "#" },
                "geology": { pdf: "#", flipbook: "#" },
                "biology": { pdf: "#", flipbook: "#" },
                "physics": { pdf: "#", flipbook: "#" },
                "chemistry": { pdf: "#", flipbook: "#" },
                "morality": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "homeeconomic": { pdf: "#", flipbook: "#" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "history": { pdf: "#", flipbook: "#" },
                "geography": { pdf: "#", flipbook: "#" },
                "geology": { pdf: "#", flipbook: "#" },
                "biology": { pdf: "#", flipbook: "#" },
                "physics": { pdf: "#", flipbook: "#" },
                "chemistry": { pdf: "#", flipbook: "#" },
                "morality": { pdf: "#", flipbook: "#" },
                "khmer": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" },
                "homeeconomic": { pdf: "#", flipbook: "#" }
            }
        },
        "11": {
            "cambodia": {
                "math": { pdf: "1NaQYd0A7KyhW_5_yZ5ECFsXMgt7buRz5", flipbook: "https://online.fliphtml5.com/frszu/eywa/" },
                "chemistry": { pdf: "1SGUiRI8pn3RjaFii0TLraFkmyZz4tQ13", flipbook: "https://online.fliphtml5.com/frszu/bnao/" },
                "biology": { pdf: "1WkQeps-ZCxjgq6_cp7D8vEzeDbBTJm5k", flipbook: "#" },
                "history": { pdf: "1YpQ7c-AaiLC3nRZt0x0BBObRwn_gWu97", flipbook: "#" },
                "geology": { pdf: "1FsY6Q307POOmfkiorX_9LXqjWKpC6tOj", flipbook: "#" },
                "geography": { pdf: "1n8LJdHvqtLIV4j-EojjVCMyhRRDNRB9_", flipbook: "#" },
                "physics": { pdf: "1OPLZFL7d6OAiXAiBbkn-5ZxOBeB6MCBT", flipbook: "https://online.fliphtml5.com/ayjcf/mcwq/" },
                "morality": { pdf: "1MMhVWhqTEiKBsCM4Hgl0miWGm792Zp0o", flipbook: "#" },
                "english": { pdf: "1EyekbhoLLRSf21dEr9lEJs7ROI3BP2Co", flipbook: "https://online.fliphtml5.com/ayjcf/vern/" },
                "khmer": { pdf: "1IfVeWVxJwlGGYWGMqrnMBNjXAdjddUK9", flipbook: "https://online.fliphtml5.com/ayjcf/vthf/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "chemistry": { pdf: "#", flipbook: "#" },
                "biology": { pdf: "#", flipbook: "#" },
                "history": { pdf: "#", flipbook: "#" },
                "geology": { pdf: "#", flipbook: "#" },
                "geography": { pdf: "#", flipbook: "#" },
                "physics": { pdf: "#", flipbook: "#" },
                "morality": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" }
            }
        },
        "12": {
            "cambodia": {
                "math": { pdf: "", flipbook: "https://online.fliphtml5.com/frszu/eywa/" },
                "chemistry": { pdf: "1qJFtEgfVm_S4SzAnTiBQ2OJNO-Nic-kS", flipbook: "#" },
                "biology": { pdf: "1T-VVZARoJEviDjAn70X-A0o2nsp1BU-Q", flipbook: "#" },
                "history": { pdf: "1UVnl2twJy_bzWdsKTYQ_8_IZy3fkkdWA", flipbook: "#" },
                "geology": { pdf: "1DZoon-Oap3xT91Hm4GsyANdmF9YdX9C7", flipbook: "#" },
                "geography": { pdf: "1UaEJEcjeicwRmimSXTmevUfxR5Sgt2VS", flipbook: "#" },
                "physics": { pdf: "1qcowpi38uk3ZODKlDxzyEDZ4pVcelwUY", flipbook: "https://online.fliphtml5.com/yhbke/yevz/" },
                "morality": { pdf: "1QdT0anOEK-x57VrCkaVbrSiBedX3OKlr", flipbook: "#" },
                "english": { pdf: "16LOYCodyoPaSfj3FpVJLVIGz1yLIkUvj", flipbook: "https://online.fliphtml5.com/yhbke/gslb/" },
                "khmer": { pdf: "1CPwnyQK9_Pae_vRYf_7sm7P98OIT5eH-", flipbook: "https://online.fliphtml5.com/yhbke/wqqz/" },
                "virtual-lab": { pdf: "#", flipbook: "#" },
                "ai-education": {
                    pdf: "#",
                    flipbook: "#",
                    aiTools: [
                        { url: "https://toolbaz.com/", name: "Toolbaz AI" },
                        { url: "https://www.magicschool.ai/", name: "MagicSchool AI" },
                        { url: "https://www.eduaide.ai/", name: "EduAide AI" },
                        { url: "https://www.teachy.app/en/", name: "Teachy AI" }
                    ]
                }
            },
            "america": {
                "math": { pdf: "#", flipbook: "#" },
                "chemistry": { pdf: "#", flipbook: "#" },
                "biology": { pdf: "#", flipbook: "#" },
                "history": { pdf: "#", flipbook: "#" },
                "geology": { pdf: "#", flipbook: "#" },
                "geography": { pdf: "#", flipbook: "#" },
                "physics": { pdf: "#", flipbook: "#" },
                "morality": { pdf: "#", flipbook: "#" },
                "english": { pdf: "#", flipbook: "#" }
            }
        }
    };

    const baseURL = "https://drive.google.com/drive/folders/";

    // Validate grade, program, and subject
    const isValidGrade = grade in grades;
    const isValidProgram = isValidGrade && program in grades[grade];
    const isValidSubject = isValidProgram && normalizedSubject in grades[grade][program];
    const links = isValidSubject ? grades[grade][program][normalizedSubject] : { pdf: null, flipbook: null, aiTools: [] };
    const pdfLink = links.pdf && links.pdf !== '#' ? `${baseURL}${links.pdf}` : null;
    const flipbookLink = links.flipbook && links.flipbook !== '#' ? links.flipbook : null;

    return (
        <div style={{
            maxWidth: '672px',
            margin: '24px auto',
            padding: '24px',
            backgroundColor: '#fff',
            borderRadius: '8px',
            boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)'
        }}>
            <h1 style={{
                fontSize: '24px',
                fontWeight: '700',
                color: '#1f2937',
                marginBottom: '16px'
            }}>
                Lesson for Grade {grade}: {program.charAt(0).toUpperCase() + program.slice(1)} Program
            </h1>
            <p style={{
                fontSize: '18px',
                color: '#374151',
                marginBottom: '16px'
            }}>
                <span style={{ fontWeight: '600' }}>Subject:</span> {subject.charAt(0).toUpperCase() + subject.slice(1)}
            </p>
            {(pdfLink || flipbookLink || (links.aiTools && links.aiTools.length > 0)) ? (
                <div style={{
                    display: 'flex',
                    flexDirection: 'column',
                    gap: '12px'
                }}>
                    <p style={{ color: '#4b5563', fontWeight: '500' }}>Access the lesson materials:</p>
                    {pdfLink && (
                        <a
                            href={pdfLink}
                            target="_blank"
                            rel="noopener noreferrer"
                            style={{
                                padding: '8px 16px',
                                backgroundColor: '#2563eb',
                                color: '#fff',
                                fontWeight: '500',
                                borderRadius: '4px',
                                textDecoration: 'none',
                                transition: 'background-color 0.2s',
                                textAlign: 'center',
                                display: 'inline-block'
                            }}
                            onMouseOver={(e) => e.currentTarget.style.backgroundColor = '#1d4ed8'}
                            onMouseOut={(e) => e.currentTarget.style.backgroundColor = '#2563eb'}
                            aria-label={`View ${subject} Grade ${grade} PDF`}
                        >
                            View PDF
                        </a>
                    )}
                    {flipbookLink && (
                        <a
                            href={flipbookLink}
                            target="_blank"
                            rel="noopener noreferrer"
                            style={{
                                padding: '8px 16px',
                                backgroundColor: '#059669',
                                color: '#fff',
                                fontWeight: '500',
                                borderRadius: '4px',
                                textDecoration: 'none',
                                transition: 'background-color 0.2s',
                                textAlign: 'center',
                                display: 'inline-block'
                            }}
                            onMouseOver={(e) => e.currentTarget.style.backgroundColor = '#047857'}
                            onMouseOut={(e) => e.currentTarget.style.backgroundColor = '#059669'}
                            aria-label={`View ${subject} Grade ${grade} Flipbook`}
                        >
                            View Flipbook
                        </a>
                    )}
                    {links.aiTools && links.aiTools.length > 0 && (
                        <div style={{ display: 'flex', flexDirection: 'column', gap: '12px', marginTop: '12px' }}>
                            <p style={{ color: '#4b5563', fontWeight: '500' }}>AI Education Tools:</p>
                            {links.aiTools.map((tool, index) => (
                                <a
                                    key={index}
                                    href={tool.url}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    style={{
                                        padding: '8px 16px',
                                        backgroundColor: '#8B5CF6',
                                        color: '#fff',
                                        fontWeight: '500',
                                        borderRadius: '4px',
                                        textDecoration: 'none',
                                        transition: 'background-color 0.2s',
                                        textAlign: 'center',
                                        display: 'inline-block'
                                    }}
                                    onMouseOver={(e) => e.currentTarget.style.backgroundColor = '#7C3AED'}
                                    onMouseOut={(e) => e.currentTarget.style.backgroundColor = '#8B5CF6'}
                                    aria-label={`Visit ${tool.name || 'AI Tool'} for Grade ${grade}`}
                                >
                                    {tool.name || `AI Tool ${index + 1}`}
                                </a>
                            ))}
                        </div>
                    )}
                </div>
            ) : (
                <div style={{
                    padding: '16px',
                    backgroundColor: '#fee2e2',
                    borderLeft: '4px solid #ef4444',
                    borderRadius: '4px'
                }}
                     aria-live="polite">
                    <p style={{ color: '#b91c1c' }}>
                        {isValidGrade
                            ? isValidProgram
                                ? `No materials available for ${subject} in ${program} program for Grade ${grade}.`
                                : `Invalid program: ${program} for Grade ${grade}.`
                            : `Invalid grade: ${grade}.`}
                    </p>
                    <p style={{ color: '#b91c1c', marginTop: '8px' }}>
                        Please check the grade, program, or subject, or{' '}
                        <a
                            href="mailto:support@example.com"
                            style={{ color: '#2563eb', textDecoration: 'underline' }}
                            onMouseOver={(e) => e.currentTarget.style.color = '#1d4ed8'}
                            onMouseOut={(e) => e.currentTarget.style.color = '#2563eb'}
                            aria-label="Contact support"
                        >
                            contact support
                        </a>{' '}
                        for assistance.
                    </p>
                </div>
            )}
        </div>
    );
}
