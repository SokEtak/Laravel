import { usePage } from '@inertiajs/react';

interface User {
    roles: string[];
}

interface PageProps {
    auth: {
        user: User | null;
    };
}

export default function Welcome() {
    const { auth } = usePage().props as PageProps;
    const user = auth?.user;

    return (
        <>
            <link rel="preconnect" href="https://fonts.bunny.net" />
            <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

            <div className="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                <header className="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
                    <nav className="flex items-center justify-end gap-4">
                        <a
                            href="#"
                            className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            About Us
                        </a>
                        <a
                            href="#"
                            className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            Contact
                        </a>

                        {user ? (
                            <a
                                href={route("dashboard")}
                                className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                            >
                                Dashboard
                            </a>
                        ) : (
                            <>
                                <a
                                    href={route("login")}
                                    className="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                                >
                                    Log in
                                </a>
                                <a
                                    href={route("register")}
                                    className="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                                >
                                    Register
                                </a>
                            </>
                        )}
                    </nav>
                </header>

                <div className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main className="flex w-full max-w-[335px] flex-col-reverse lg:max-w-4xl lg:flex-row">
                        <section className="flex flex-col items-center justify-center text-center p-8 bg-white dark:bg-[#1a1a1a] rounded-lg shadow-lg w-full">
                            <h1 className="text-4xl lg:text-5xl font-extrabold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                                Discover Your Next Favorite
                            </h1>
                            <p className="text-lg lg:text-xl text-[#52524E] dark:text-[#B6B6B3] mb-8 max-w-2xl">
                                Explore a curated collection of high-quality products, from fashion to home decor,
                                designed to elevate your lifestyle. Shop with ease and find exactly what you need.
                            </p>
                            <a
                                href="#"
                                className="inline-block bg-[#1b1b18] text-[#FDFDFC] px-8 py-3 rounded-md text-lg font-medium hover:bg-[#32322E] transition-colors duration-200 dark:bg-[#EDEDEC] dark:text-[#0a0a0a] dark:hover:bg-[#D4D4D1]"
                            >
                                Shop Now
                            </a>
                        </section>
                    </main>
                </div>

                <div className="hidden h-14.5 lg:block"></div>
            </div>
        </>
    );
}
