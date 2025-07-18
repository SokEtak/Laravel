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

export default function Subject() {
    const { props, url } = usePage<PageProps<{ program?: string; grade?: string }>>();
    const { program, grade } = props;

    // Get initial lang from query string
    const queryParams = new URLSearchParams(url.split('?')[1]);
    const initialLang = queryParams.get('lang') === 'km' ? 'km' : 'en';

    const [lang, setLang] = useState<'en' | 'km'>(initialLang);
    const [subject, setSubject] = useState('');

    // Update lang if query changes
    useEffect(() => {
        const newLang = queryParams.get('lang') === 'km' ? 'km' : 'en';
        setLang(newLang);
    }, [url]);

    // Mapping of grades to subjects based on program
    const gradeSubjects: { [key: string]: { [key: string]: { value: string; en: string; km: string }[] } } = {
        "1": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'សិក្សាសង្គម' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "2": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "3": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' },
                { value: 'reading', en: 'Reading', km: 'អំណាន' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "4": {
            "cambodia": [
                { value: 'chaching', en: 'Cha Ching', km: 'កម្មវិធីសិក្សា-ឆាឈីង' },
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'history', en: 'History Of Science', km: 'ប្រវិត្តិសាស្ត្រ' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "5": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'science', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'សិក្សាសង្គម' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "6": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'history', en: 'History', km: 'ប្រវិត្តិសាស្ត្រ' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'សិក្សាសង្គម' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវิទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "7": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "8": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' },
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "9": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' },
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'social', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "10": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'history', en: 'History Of Science', km: 'ប្រវិត្តវិទ្យា' },
                { value: 'geography', en: 'Geography', km: 'ភូមិវិទ្យា' },
                { value: 'geology', en: 'Earth And Environmental Science ', km: 'ផែនដីវិទ្យា' },
                { value: 'biology', en: 'Biology', km: 'ជីវវិទ្យា' },
                { value: 'physics', en: 'Physics', km: 'រូបវិទ្យា' },
                { value: 'chemistry', en: 'Chemistry', km: 'គីមីវិទ្យា' },
                { value: 'morality', en: 'Morality-Civics', km: 'សីលធម៌-ពលរដ្ធវិជ្ជា' },
                { value: 'khmer', en: 'Khmer Language', km: 'ភាសាខ្មែរ' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'homeeconomic', en: 'Home Economic', km: 'គេហវិទ្យា' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'science', en: 'Science', km: 'វិទ្យាសាស្ត្រ' },
                { value: 'socialscience', en: 'Social Science', km: 'វិទ្យាសាស្ត្រ-សិក្សាសង្គម' }
            ],
            "extras": []
        },
        "11": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'chemistry', en: 'Chemistry', km: 'គីមីវិទ្យា' },
                { value: 'biology', en: 'Biology', km: 'ជីវវិទ្យា' },
                { value: 'history', en: 'History', km: 'ប្រវិត្តិសាស្ត្រ' },
                { value: 'geology', en: 'Geology', km: 'ភូគព្ភវិទ្យា' },
                { value: 'geography', en: 'Geography', km: 'ភូមិវិទ្យា' },
                { value: 'physics', en: 'Physics', km: 'រូបវិទ្យា' },
                { value: 'morality', en: 'Morality', km: 'សីលធម៌' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'khmer', en: 'Khmer Language', km: 'អក្សរសាស្ត្រខ្មែរ' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'chemistry', en: 'Chemistry', km: 'គីមីវិទ្យា' },
                { value: 'biology', en: 'Biology', km: 'ជីវវិទ្យា' }
            ],
            "extras": []
        },
        "12": {
            "cambodia": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'chemistry', en: 'Chemistry', km: 'គីមីវិទ្យា' },
                { value: 'biology', en: 'Biology', km: 'ជីវវិទ្យា' },
                { value: 'history', en: 'History', km: 'ប្រវិត្តិសាស្ត្រ' },
                { value: 'geology', en: 'Earth And Environmental Science', km: 'ផែនដីវិទ្យានិងបរិស្ថានវិទ្យា' },
                { value: 'geography', en: 'Geography', km: 'ភូមិវិទ្យា' },
                { value: 'physics', en: 'Physics', km: 'រូបវិទ្យា' },
                { value: 'morality', en: 'Morality-Civics', km: 'សីលធម៌' },
                { value: 'english', en: 'English', km: 'ភាសាអង់គ្លេស' },
                { value: 'khmer', en: 'Khmer Language', km: 'អក្សរសាស្ត្រខ្មែរ' },
                { value: 'virtual-lab', en: 'Virtual Lab', km: 'មន្ទីរពិសោធន៍និម្មិត' },
                { value: 'ai-education', en: 'AI Education', km: 'ការអប់រំ AI' }
            ],
            "america": [
                { value: 'math', en: 'Mathematics', km: 'គណិតវិទ្យា' },
                { value: 'chemistry', en: 'Chemistry', km: 'គីមីវិទ្យា' },
                { value: 'biology', en: 'Biology', km: 'ជីវវិទ្យា' }
            ],
            "extras": []
        },
        "club1": {
            "cambodia": [],
            "america": [],
            "extras": [
                { value: 'art', en: 'Art', km: 'សិល្បៈ' },
                { value: 'music', en: 'Music', km: 'តន្ត្រី' },
                { value: 'sports', en: 'Sports', km: 'កីឡា' }
            ]
        },
        "club2": {
            "cambodia": [],
            "america": [],
            "extras": [
                { value: 'drama', en: 'Drama', km: 'ល្ខោន' },
                { value: 'dance', en: 'Dance', km: 'របាំ' },
                { value: 'debate', en: 'Debate', km: 'ការពិភាក្សា' }
            ]
        }
    };

    // Map program text
    const programText =
        program === "cambodia"
            ? (lang === 'en' ? "Cambodia Curriculum" : "កម្មវិធីសិក្សាខ្មែរ")
            : program === "america"
                ? (lang === 'en' ? "American Curriculum" : "កម្មវិធីសិក្សាអាមេរិកកាំង")
                : (lang === 'en' ? "Extra Curricular Curriculum" : "កម្មវិធីសិក្សាបន្ថែម");

    // Display program and grade
    const programGradeText = grade && program
        ? (lang === 'en'
                ? (["club1", "club2"].includes(grade) ? `${grade.charAt(0).toUpperCase() + grade.slice(4)} Level: ` : `Grade ${grade}: `) + programText
                : (["club1", "club2"].includes(grade) ? `${grade.charAt(0).toUpperCase() + grade.slice(4)} កម្រិត: ` : `ថ្នាក់ទី ${grade}: `) + programText
        ) : '-';

    // Get subjects for the current grade and program, default to empty array if invalid
    const availableSubjects = grade && program && grade in gradeSubjects && program in gradeSubjects[grade]
        ? gradeSubjects[grade][program]
        : [];

    return (
        <>
            <Head title={lang === 'en' ? 'Subject Selection' : 'ជ្រើសរើសមុខវិជ្ជា'} />
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

                        {/* Show program and grade */}
                        <h2 className="text-lg font-semibold text-white mb-4">
                            {programGradeText ?? "no value"}
                        </h2>

                        <h1 className="text-2xl sm:text-3xl font-bold text-white mb-6 drop-shadow">
                            {lang === 'en' ? 'Select Subject' : 'ជ្រើសរើសមុខវិជ្ជា'}
                        </h1>

                        {/* Subject Select */}
                        <div className="w-full mb-5 text-left">
                            <label className="block mb-2 font-semibold text-white">
                                {lang === 'en' ? 'Choose Subject' : 'ជ្រើសរើសមុខវិជ្ជា'}
                            </label>
                            <Select onValueChange={setSubject} value={subject}>
                                <SelectTrigger className="w-full bg-white/90 text-gray-800">
                                    <SelectValue placeholder={lang === 'en' ? 'Select a subject' : 'ជ្រើសរើសមុខវិជ្ជា'} />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        {availableSubjects.map((subj) => (
                                            <SelectItem key={subj.value} value={subj.value}>
                                                {lang === 'en' ? subj.en : subj.km}
                                            </SelectItem>
                                        ))}
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        {/* Continue button */}
                        <a
                            href={subject && program && grade ? `/lessons?program=${program}&grade=${grade}&subject=${subject}` : '#'}
                            className={`mt-3 w-full rounded-lg px-4 py-3 font-semibold text-white transition ${
                                subject ? 'bg-violet-600 hover:bg-violet-700' : 'bg-gray-400 pointer-events-none'
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
