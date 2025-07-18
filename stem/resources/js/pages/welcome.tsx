import { useState } from 'react';
import { Head } from '@inertiajs/react';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

export default function Welcome() {
    const [campus, setCampus] = useState('');
    const [program, setProgram] = useState('');
    const [lang, setLang] = useState<'en' | 'km'>('en');

    return (
        <>
            <Head title="Dewey School Teaching Resource">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>

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
                        <h1 className="text-2xl sm:text-3xl font-bold text-white mb-6 drop-shadow">
                            {lang === 'en' ? 'Dewey School Teaching Resource' : 'ធនធានបង្រៀនសាលាឌូវី'}
                        </h1>

                        {/* Campus Select */}
                        <div className="w-full mb-5 text-left">
                            <label className="block mb-2 font-semibold text-white">
                                {lang === 'en' ? 'Choose Campus' : 'ជ្រើសរើសទីតាំង'}
                            </label>
                            <Select onValueChange={setCampus}>
                                <SelectTrigger className="w-full bg-white/90 text-gray-800">
                                    <SelectValue placeholder={lang === 'en' ? "Select a campus" : "ជ្រើសរើសទីតាំង"} />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        {lang === 'en' ? (
                                            <>
                                                <SelectItem value="iconic">Dewey International School, Iconic Branch</SelectItem>
                                                <SelectItem value="ochar">Dewey International School, Ochar Branch</SelectItem>
                                                <SelectItem value="banteay">Dewey International School, Banteay Meanchey Branch</SelectItem>
                                                <SelectItem value="childcare">Dewey Childcare House</SelectItem>
                                                <SelectItem value="kindergarten">Dewey Kindergarten</SelectItem>
                                            </>
                                        ) : (
                                            <>
                                                <SelectItem value="iconic">សាលាឌូវី សាខាអាយខនិក</SelectItem>
                                                <SelectItem value="ochar">សាលាឌូវី សាខាអូរចារ</SelectItem>
                                                <SelectItem value="banteay">សាលាឌូវី សាខាបន្ទាយមានជ័យ</SelectItem>
                                                <SelectItem value="childcare">ឌូវី ឆាល់ឃែរ៍ ហោស៍</SelectItem>
                                                <SelectItem value="kindergarten">មតេយ្យ ឌូវី</SelectItem>
                                            </>
                                        )}
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        {/* Program Select */}
                        <div className="w-full mb-5 text-left">
                            <label className="block mb-2 font-semibold text-white">
                                {lang === 'en' ? 'Choose Program' : 'ជ្រើសរើសកម្មវិធីសិក្សា'}
                            </label>
                            <Select onValueChange={setProgram}>
                                <SelectTrigger className="w-full bg-white/90 text-gray-800">
                                    <SelectValue placeholder={lang === 'en' ? "Select a program" : "ជ្រើសរើសកម្មវិធី"} />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        {lang === 'en' ? (
                                            <>
                                                <SelectItem value="cambodia">Cambodia Curriculum</SelectItem>
                                                <SelectItem value="america">American Curriculum</SelectItem>
                                                <SelectItem value="exstra">Extra Curricular Curriculum</SelectItem>
                                            </>
                                        ) : (
                                            <>
                                                <SelectItem value="cambodia">កម្មវិធីសិក្សាខ្មែរ</SelectItem>
                                                <SelectItem value="america">កម្មវិធីសិក្សាអាមេរិកកាំង</SelectItem>
                                                <SelectItem value="exstra">កម្មវិធីសិក្សាបន្ថែម</SelectItem>
                                            </>
                                        )}
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        {/* Go button */}
                        <a
                            href={campus && program ? route('grade') + `?program=${program}` : '#'}
                            className={`mt-3 w-full rounded-lg px-4 py-3 font-semibold text-white transition ${
                                campus && program
                                    ? 'bg-violet-600 hover:bg-violet-700'
                                    : 'bg-gray-400 pointer-events-none'
                            }`}
                        >
                            {lang === 'en' ? 'Go To The Next Step' : 'ទៅកាន់ជំហានបន្ទាប់'}
                        </a>

                    </div>
                </div>

                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}
