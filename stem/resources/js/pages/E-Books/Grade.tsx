import { useState, useEffect } from 'react';
import { Head, usePage } from '@inertiajs/react';
import type { PageProps } from '@inertiajs/inertia';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

export default function Grade() {
    const { props, url } = usePage<PageProps<{ program?: string }>>();
    const program = props.program;

    // Get initial lang from query string
    const queryParams = new URLSearchParams(url.split('?')[1]);
    const initialLang = queryParams.get('lang') === 'km' ? 'km' : 'en';

    const [lang, setLang] = useState<'en' | 'km'>(initialLang);
    const [grade, setGrade] = useState('');

    // Optionally, update lang if query changes
    useEffect(() => {
        const newLang = queryParams.get('lang') === 'km' ? 'km' : 'en';
        setLang(newLang);
    }, [url]);

    // Map program text
    const programText =
        program === "khmer"
            ? (lang === 'en' ? "Cambodia Curriculum" : "កម្មវិធីសិក្សាខ្មែរ")
            : program === "america"
                ? (lang === 'en' ? "American Curriculum" : "កម្មវិធីសិក្សាអាមេរិកកាំង")
                : (lang === 'en' ? "Extra Curricular Curriculum" : "កម្មវិធីសិក្សាបន្ថែម");

    return (
        <>
            <Head title={lang === 'en' ? 'Grade Selection' : 'ជ្រើសរើសថ្នាក់'} />
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-indigo-300 to-purple-400 p-4 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-gradient-to-br dark:from-gray-900 dark:to-black mb-5">

                {/* Language toggle */}
                <div className="mt-5 flex space-x-2">
                    <button
                        onClick={() => setLang('en')}
                        className={`px-4 py-2 rounded ${lang === 'en' ? 'bg-violet-600 text-white' : 'bg-white text-gray-800'}`}
                    >
                        English
                    </button>
                    <button
                        onClick={() => setLang('km')}
                        className={`px-4 py-2 rounded ${lang === 'km' ? 'bg-violet-600 text-white' : 'bg-white text-gray-800'}`}
                    >
                        ខ្មែរ
                    </button>
                </div>

                {/* Main card */}
                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <div className="backdrop-blur-lg bg-white/20 rounded-2xl shadow-2xl transition-transform duration-300 hover:scale-[1.02] w-full max-w-5xl p-6 sm:p-10 text-center">

                        {/* Show program */}
                        <h2 className="text-lg font-semibold text-white mb-4">
                            {program ? programText : '-'}
                        </h2>

                        <h1 className="text-2xl sm:text-3xl font-bold text-white mb-6 drop-shadow">
                            {lang === 'en' ? 'Select Grade' : 'ជ្រើសរើសថ្នាក់'}
                        </h1>

                        {/* Grade Select */}
                        <div className="w-full mb-5 text-left">
                            <label className="block mb-2 font-semibold text-white">
                                {lang === 'en' ? 'Choose Grade' : 'ជ្រើសរើសថ្នាក់'}
                            </label>
                            <Select onValueChange={setGrade} value={grade}>
                                <SelectTrigger className="w-full bg-white/90 text-gray-800">
                                    <SelectValue placeholder={lang === 'en' ? 'Select a grade' : 'ជ្រើសរើសថ្នាក់'} />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        {[...Array(12).keys()].map(i => (
                                            <SelectItem key={i + 1} value={`${i + 1}`}>
                                                {lang === 'en' ? `Grade ${i + 1}` : `ថ្នាក់ទី ${i + 1}`}
                                            </SelectItem>
                                        ))}
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        {/* Continue button */}
                        <a
                            //fix
                            href={grade && program ? route('subject')+`?program=${program}&grade=${grade}`:'#'}
                            className={`mt-3 w-full rounded-lg px-4 py-3 font-semibold text-white transition ${
                                grade ? 'bg-violet-600 hover:bg-violet-700' : 'bg-gray-400 pointer-events-none'
                            }`}
                        >
                            {lang === 'en' ? 'Continue' : 'បន្ត'}
                        </a>
                    </div>
                </div>

                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}
